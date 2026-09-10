<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\ItemPenjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * =========================================================
     * RIWAYAT PENJUALAN
     * =========================================================
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $penjualan = Penjualan::with('user')
            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    // Cari berdasarkan ID transaksi
                    $q->where('id', 'like', '%' . $search . '%')

                        // Cari berdasarkan nama kasir
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );
                        })

                        // Cari berdasarkan metode pembayaran
                        ->orWhere(
                            'metode_pembayaran',
                            'like',
                            '%' . $search . '%'
                        )

                        // Cari berdasarkan status
                        ->orWhere(
                            'status',
                            'like',
                            '%' . $search . '%'
                        );
                });
            })
            ->latest()
            ->paginate(10)
            ->appends([
                'search' => $search
            ]);

        return view(
            'penjualan.index',
            compact('penjualan')
        );
    }


    /**
     * =========================================================
     * FORM TRANSAKSI BARU
     * =========================================================
     */
    public function create()
    {
        $produks = Produk::where('stok', '>', 0)->get();

        return view(
            'penjualan.create',
            compact('produks')
        );
    }


    /**
     * =========================================================
     * SIMPAN TRANSAKSI
     * =========================================================
     */
    public function store(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string',

            'items' => 'required|array|min:1',

            'items.*.produk_id' => [
                'required',
                'exists:produk,id'
            ],

            'items.*.qty' => [
                'required',
                'integer',
                'min:1'
            ],

            'items.*.harga' => [
                'required',
                'numeric'
            ],
        ]);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | 1. HITUNG TOTAL
            |--------------------------------------------------------------------------
            */

            $totalPembayaran = 0;

            foreach ($request->items as $item) {

                $totalPembayaran +=
                    $item['harga'] * $item['qty'];
            }


            /*
            |--------------------------------------------------------------------------
            | 2. SIMPAN PENJUALAN
            |--------------------------------------------------------------------------
            */

            $penjualan = Penjualan::create([
                'user_id' => Auth::id() ?? 1,

                'total_pembayaran' => $totalPembayaran,

                'metode_pembayaran' =>
                    $request->metode_pembayaran,

                'status' => 'COMPLETED',
            ]);


            /*
            |--------------------------------------------------------------------------
            | 3. SIMPAN ITEM & KURANGI STOK
            |--------------------------------------------------------------------------
            */

            foreach ($request->items as $item) {

                ItemPenjualan::create([
                    'penjualan_id' =>
                        $penjualan->id,

                    'produk_id' =>
                        $item['produk_id'],

                    'kuantitas' =>
                        $item['qty'],

                    'harga_satuan' =>
                        $item['harga'],

                    'subtotal' =>
                        $item['harga'] * $item['qty'],
                ]);


                /*
                |--------------------------------------------------------------------------
                | KURANGI STOK
                |--------------------------------------------------------------------------
                */

                $produk = Produk::findOrFail(
                    $item['produk_id']
                );

                $produk->decrement(
                    'stok',
                    $item['qty']
                );
            }


            DB::commit();

            return redirect()
                ->route(
                    'penjualan.show',
                    $penjualan->id
                )
                ->with(
                    'success',
                    'Transaksi berhasil disimpan!'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with(
                    'error',
                    'Gagal memproses transaksi: ' .
                    $e->getMessage()
                );
        }
    }


    /**
     * =========================================================
     * DETAIL PENJUALAN
     * =========================================================
     */
    public function show($id)
    {
        $penjualan = Penjualan::with([
            'user',
            'itemPenjualan.produk'
        ])->findOrFail($id);

        return view(
            'penjualan.show',
            compact('penjualan')
        );
    }


    /**
     * =========================================================
     * FORM EDIT PENJUALAN
     * HANYA BOLEH PENDING
     * =========================================================
     */
    public function edit($id)
    {
        $penjualan = Penjualan::with([
            'user',
            'itemPenjualan.produk'
        ])->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | HANYA PENDING YANG BOLEH DIEDIT
        |--------------------------------------------------------------------------
        */

        if (strtoupper($penjualan->status) !== 'PENDING') {

            return redirect()
                ->route(
                    'penjualan.index'
                )
                ->with(
                    'error',
                    'Transaksi yang sudah COMPLETED tidak dapat diedit.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL PRODUK
        |--------------------------------------------------------------------------
        */

        $produks = Produk::all();


        return view(
            'penjualan.edit',
            compact(
                'penjualan',
                'produks'
            )
        );
    }


    /**
     * =========================================================
     * UPDATE PENJUALAN
     * HANYA PENDING
     * =========================================================
     */
    public function update(Request $request, $id)
    {
        $penjualan = Penjualan::with(
            'itemPenjualan'
        )->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | CEK STATUS
        |--------------------------------------------------------------------------
        */

        if (strtoupper($penjualan->status) !== 'PENDING') {

            return redirect()
                ->route(
                    'penjualan.index'
                )
                ->with(
                    'error',
                    'Transaksi yang sudah COMPLETED tidak dapat diubah.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'metode_pembayaran' =>
                'required|string',

            'status' => [
                'required',
                'in:PENDING,COMPLETED'
            ],
        ]);


        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | UPDATE DATA PENJUALAN
            |--------------------------------------------------------------------------
            */

            $penjualan->update([
                'metode_pembayaran' =>
                    $request->metode_pembayaran,

                'status' =>
                    $request->status,
            ]);


            DB::commit();

            return redirect()
                ->route(
                    'penjualan.index'
                )
                ->with(
                    'success',
                    'Transaksi berhasil diperbarui!'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal memperbarui transaksi: ' .
                    $e->getMessage()
                );
        }
    }


    /**
     * =========================================================
     * HAPUS PENJUALAN
     * HANYA PENDING
     * =========================================================
     */
    public function destroy($id)
    {
        $penjualan = Penjualan::with(
            'itemPenjualan'
        )->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | HANYA PENDING YANG BOLEH DIHAPUS
        |--------------------------------------------------------------------------
        */

        if (strtoupper($penjualan->status) !== 'PENDING') {

            return redirect()
                ->route(
                    'penjualan.index'
                )
                ->with(
                    'error',
                    'Transaksi yang sudah COMPLETED tidak dapat dihapus.'
                );
        }


        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | KEMBALIKAN STOK
            |--------------------------------------------------------------------------
            */

            foreach (
                $penjualan->itemPenjualan
                as $item
            ) {

                $produk = Produk::find(
                    $item->produk_id
                );

                if ($produk) {

                    $produk->increment(
                        'stok',
                        $item->kuantitas
                    );
                }
            }


            /*
            |--------------------------------------------------------------------------
            | HAPUS ITEM PENJUALAN
            |--------------------------------------------------------------------------
            */

            ItemPenjualan::where(
                'penjualan_id',
                $penjualan->id
            )->delete();


            /*
            |--------------------------------------------------------------------------
            | HAPUS PENJUALAN
            |--------------------------------------------------------------------------
            */

            $penjualan->delete();


            DB::commit();

            return redirect()
                ->route(
                    'penjualan.index'
                )
                ->with(
                    'success',
                    'Transaksi PENDING berhasil dihapus dan stok dikembalikan.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->route(
                    'penjualan.index'
                )
                ->with(
                    'error',
                    'Gagal menghapus transaksi: ' .
                    $e->getMessage()
                );
        }
    }
}