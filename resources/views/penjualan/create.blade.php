@extends('layouts.app')

@section('title', 'Transaksi Baru - Kasir POS')

@section('content')

@include('layouts.navbar')

<style>
    :root {
        --bg-main: #090d16;
        --card-bg: #1e293b;
        --card-border: rgba(255, 255, 255, 0.08);
        --accent-indigo: #6366f1;
        --accent-emerald: #10b981;
    }

    body {
        background-color: var(--bg-main) !important;
        color: #f8fafc !important;
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
    }

    /* Modern Card Layout */
    .card-pro {
        background: var(--card-bg) !important;
        border: 1px solid var(--card-border);
        border-radius: 1.25rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
    }

    .card-header-pro {
        background: #0f172a !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 1rem 1.25rem;
        border-radius: 1.25rem 1.25rem 0 0;
    }

    /* Product Grid Card */
    .product-card {
        background: #0f172a;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 1rem;
        padding: 1rem;
        transition: all 0.2s ease;
        cursor: pointer;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .product-card:hover {
        border-color: #6366f1;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px -5px rgba(99, 102, 241, 0.3);
    }

    .product-img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 0.75rem;
        margin-bottom: 0.75rem;
    }

    /* Input Style Dark */
    .form-control-dark,
    .form-select-dark {
        background-color: #0f172a !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #f8fafc !important;
        border-radius: 0.75rem !important;
        padding: 0.65rem 1rem;
    }

    .form-control-dark:focus,
    .form-select-dark:focus {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25) !important;
    }

    /*
    ============================================
    DROPDOWN METODE PEMBAYARAN
    ============================================
    */

    #metodePembayaran {
        background-color: #0f172a !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        border-radius: 0.75rem !important;
        padding: 0.75rem 1rem;
    }

    #metodePembayaran option {
        background-color: #1e293b !important;
        color: #ffffff !important;
        padding: 10px;
    }

    #metodePembayaran:hover {
        border-color: #6366f1 !important;
    }

    #metodePembayaran:focus {
        background-color: #0f172a !important;
        color: #ffffff !important;
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25) !important;
        outline: none !important;
    }

    /* Table Cart */
    .table-cart {
        color: #f1f5f9 !important;
        margin-bottom: 0;
    }

    .table-cart th {
        background-color: #0f172a !important;
        color: #94a3b8 !important;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding: 0.75rem;
    }

    .table-cart td {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
        padding: 0.75rem;
        vertical-align: middle;
    }

    .btn-checkout {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        font-weight: 700;
        border-radius: 0.75rem;
        padding: 0.85rem;
        border: none;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4);
        transition: all 0.25s ease;
        width: 100%;
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
        color: #ffffff;
    }

    .btn-back-pro {
        background: rgba(148, 163, 184, 0.15);
        color: #cbd5e1;
        border: 1px solid rgba(255, 255, 255, 0.1);
        font-weight: 600;
        border-radius: 0.75rem;
        padding: 0.65rem 1.25rem;
        text-decoration: none;
    }

    .btn-back-pro:hover {
        background: rgba(148, 163, 184, 0.25);
        color: #ffffff;
    }

    /* Modal Dark Theme Overrides */
    .modal-dark {
        background-color: #1e293b !important;
        color: #f8fafc !important;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 1.25rem;
    }

    .modal-dark .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .modal-dark .modal-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }
</style>

<div class="container-fluid px-4 py-4">

    {{-- HEADER PAGE --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-black text-white mb-1" style="font-size: 1.75rem;">
                <i class="bi bi-calculator text-indigo-400 me-2" style="color: #818cf8;"></i>
                Kasir Transaksi
            </h1>

            <p class="text-slate-400 mb-0 small" style="color: #94a3b8;">
                Pilih produk untuk ditambahkan ke keranjang belanja.
            </p>
        </div>

        <a href="{{ route('penjualan.index') }}" class="btn btn-back-pro">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali ke Riwayat
        </a>
    </div>

    <form action="{{ route('penjualan.store') }}" method="POST" id="formKasir">
        @csrf

        <div class="row g-4">

            {{-- SEKSI KIRI: KATALOG PRODUK --}}
            <div class="col-12 col-lg-7 col-xl-8">

                <div class="card card-pro p-3 mb-4">
                    <div class="input-group">

                        <span
                            class="input-group-text border-0 text-slate-400"
                            style="
                                background: #0f172a;
                                border-radius: 0.75rem 0 0 0.75rem;
                            "
                        >
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="text"
                            id="searchProduk"
                            class="form-control form-control-dark border-start-0"
                            placeholder="Cari nama produk..."
                            style="border-radius: 0 0.75rem 0.75rem 0 !important;"
                        >

                    </div>
                </div>

                {{-- DAFTAR PRODUK --}}
                <div class="row g-3" id="daftarProduk">

                    @forelse($produks as $item)

                    <div
                        class="col-6 col-md-4 col-xl-3 item-produk-wrapper"
                        data-nama="{{ strtolower($item->nama) }}"
                    >

                        <div
                            class="product-card"
                            onclick="addToCart(
                                {{ $item->id }},
                                '{{ addslashes($item->nama) }}',
                                {{ $item->harga_jual }},
                                {{ $item->stok }}
                            )"
                        >

                            <div>

                                @if($item->foto)

                                    <img
                                        src="{{ asset('storage/' . $item->foto) }}"
                                        alt="{{ $item->nama }}"
                                        class="product-img"
                                    >

                                @else

                                    <div
                                        class="product-img d-flex align-items-center justify-content-center bg-slate-800 text-slate-500"
                                    >
                                        <i class="bi bi-image fs-2"></i>
                                    </div>

                                @endif

                                <h6
                                    class="fw-bold text-white mb-1 text-truncate"
                                    title="{{ $item->nama }}"
                                >
                                    {{ $item->nama }}
                                </h6>

                                <div
                                    class="small text-slate-400 mb-2"
                                >
                                    Stok:
                                    <span class="fw-bold text-white">
                                        {{ $item->stok }}
                                    </span>
                                </div>

                            </div>

                            <div
                                class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top border-secondary border-opacity-10"
                            >

                                <span
                                    class="fw-bold font-monospace"
                                    style="color: #34d399;"
                                >
                                    Rp {{ number_format($item->harga_jual, 0, ',', '.') }}
                                </span>

                                <button
                                    type="button"
                                    class="btn btn-sm rounded-circle btn-indigo"
                                    style="background: #6366f1; color: white;"
                                >
                                    <i class="bi bi-plus-lg"></i>
                                </button>

                            </div>

                        </div>

                    </div>

                    @empty

                    <div class="col-12 text-center py-5 text-slate-400">

                        <i class="bi bi-box-seam fs-1 d-block mb-2"></i>

                        Belum ada data produk berstok yang tersedia.

                    </div>

                    @endforelse

                </div>

            </div>


            {{-- SEKSI KANAN: KERANJANG & CHECKOUT --}}
            <div class="col-12 col-lg-5 col-xl-4">

                <div class="card card-pro">

                    {{-- HEADER KERANJANG --}}
                    <div
                        class="card-header-pro d-flex justify-content-between align-items-center"
                    >

                        <h6 class="fw-bold text-white mb-0">

                            <i
                                class="bi bi-cart3 me-2"
                                style="color: #38bdf8;"
                            ></i>

                            Keranjang Belanja

                        </h6>

                        <button
                            type="button"
                            class="btn btn-sm text-danger p-0"
                            onclick="clearCart()"
                        >

                            <i class="bi bi-trash"></i>
                            Kosongkan

                        </button>

                    </div>


                    {{-- TABEL KERANJANG --}}
                    <div class="card-body p-0">

                        <div
                            class="table-responsive"
                            style="max-height: 300px; overflow-y: auto;"
                        >

                            <table class="table table-cart align-middle">

                                <thead>

                                    <tr>

                                        <th>
                                            Produk
                                        </th>

                                        <th
                                            class="text-center"
                                            style="width: 80px;"
                                        >
                                            Qty
                                        </th>

                                        <th class="text-end">
                                            Subtotal
                                        </th>

                                        <th style="width: 40px;"></th>

                                    </tr>

                                </thead>

                                <tbody id="cartTableBody">

                                    <tr id="emptyCartRow">

                                        <td
                                            colspan="4"
                                            class="text-center py-4 text-slate-400 small"
                                        >
                                            Keranjang masih kosong.
                                            <br>
                                            Klik produk di sebelah kiri.
                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>


                    {{-- TOTAL & METODE BAYAR --}}
                    <div
                        class="card-footer p-4"
                        style="
                            background: #0f172a;
                            border-top: 1px solid rgba(255,255,255,0.08);
                        "
                    >

                        {{-- METODE PEMBAYARAN --}}
                        <div class="mb-3">

                            <label
                                class="form-label fw-bold small"
                                style="color: #cbd5e1;"
                            >
                                Metode Pembayaran
                            </label>

                            <select
                                name="metode_pembayaran"
                                id="metodePembayaran"
                                class="form-select form-select-dark"
                                required
                                style="
                                    background-color: #0f172a !important;
                                    color: #ffffff !important;
                                    border: 1px solid rgba(255,255,255,0.15) !important;
                                    border-radius: 0.75rem !important;
                                    padding: 0.75rem 1rem;
                                "
                            >

                                <option
                                    value="QRIS"
                                    style="
                                        background-color: #1e293b;
                                        color: #ffffff;
                                    "
                                >
                                    QRIS
                                </option>

                                <option
                                    value="CASH"
                                    style="
                                        background-color: #1e293b;
                                        color: #ffffff;
                                    "
                                >
                                    CASH / TUNAI
                                </option>

                                

                            </select>

                        </div>


                        {{-- TOTAL PEMBAYARAN --}}
                        <div
                            class="p-3 mb-3 rounded-3"
                            style="
                                background: rgba(16,185,129,0.1);
                                border: 1px solid rgba(16,185,129,0.2);
                            "
                        >

                            <div
                                class="small text-slate-400"
                            >
                                Total Pembayaran
                            </div>

                            <div
                                class="fs-2 font-monospace fw-black"
                                style="color: #34d399;"
                                id="displayTotal"
                            >
                                Rp 0
                            </div>

                        </div>


                        {{-- TOMBOL SELESAIKAN TRANSAKSI --}}
                        <button
                            type="button"
                            class="btn btn-checkout fw-bold d-flex align-items-center justify-content-center gap-2"
                            id="btnSubmit"
                            onclick="handleCheckout()"
                            disabled
                        >

                            <i class="bi bi-check-circle-fill"></i>

                            Selesaikan Transaksi

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>


{{-- MODAL POPUP QRIS --}}
<div
    class="modal fade"
    id="modalQris"
    tabindex="-1"
    aria-labelledby="modalQrisLabel"
    aria-hidden="true"
    data-bs-backdrop="static"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content modal-dark text-center">

            <div class="modal-header justify-content-center">

                <h5
                    class="modal-title fw-bold text-white"
                    id="modalQrisLabel"
                >

                    <i
                        class="bi bi-qr-code-scan me-2 text-indigo-400"
                    ></i>

                    Pembayaran QRIS

                </h5>

            </div>


            <div class="modal-body p-4">

                <p
                    class="text-slate-300 mb-2 small"
                >
                    Pindai kode QR di bawah ini menggunakan aplikasi
                    M-Banking atau E-Wallet.
                </p>


                {{-- NOMINAL TOTAL --}}
                <div
                    class="bg-dark p-2 rounded mb-3 border border-secondary border-opacity-25"
                >

                    <span
                        class="text-slate-400 small d-block"
                    >
                        Total tagihan:
                    </span>

                    <span
                        class="fs-3 fw-bold font-monospace"
                        style="color: #34d399;"
                        id="qrisTotalDisplay"
                    >
                        Rp 0
                    </span>

                </div>


                {{-- GAMBAR QR CODE --}}
                <div
                    class="bg-white p-3 rounded-4 d-inline-block shadow-lg my-2"
                >

                    <img
                        src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=QRIS_DEMO_POS"
                        alt="QRIS Code"
                        class="img-fluid"
                        style="max-width: 220px;"
                    >

                </div>


                <div class="mt-3">

                    <span
                        class="badge bg-emerald-500 bg-opacity-20 text-emerald-400 px-3 py-2 rounded-pill small"
                        style="
                            background: rgba(16,185,129,0.15);
                            color: #34d399;
                        "
                    >

                        <i class="bi bi-clock me-1"></i>

                        Menunggu Konfirmasi Pembayaran

                    </span>

                </div>

            </div>


            <div class="modal-footer d-flex gap-2">

                <button
                    type="button"
                    class="btn btn-outline-secondary btn-sm rounded-3 flex-fill text-slate-300"
                    data-bs-dismiss="modal"
                >
                    Batal
                </button>

                <button
                    type="button"
                    class="btn btn-checkout btn-sm rounded-3 flex-fill"
                    onclick="submitFormDirectly()"
                >

                    <i class="bi bi-check2-circle me-1"></i>

                    Konfirmasi & Simpan

                </button>

            </div>

        </div>

    </div>

</div>


{{-- SCRIPT JAVASCRIPT KASIR / KERANJANG --}}
<script>

    let cart = [];
    let currentGrandTotal = 0;


    // ==========================================
    // FILTER PRODUK LIVE
    // ==========================================

    document
        .getElementById('searchProduk')
        .addEventListener('input', function(e) {

            const query = e.target.value.toLowerCase();

            const items = document.querySelectorAll(
                '.item-produk-wrapper'
            );

            items.forEach(item => {

                const nama = item.getAttribute('data-nama');

                if (nama.includes(query)) {

                    item.style.display = 'block';

                } else {

                    item.style.display = 'none';

                }

            });

        });


    // ==========================================
    // TAMBAH PRODUK KE KERANJANG
    // ==========================================

    function addToCart(id, nama, harga, stok) {

        const existing = cart.find(
            item => item.id === id
        );

        if (existing) {

            if (existing.qty < stok) {

                existing.qty += 1;

            } else {

                alert(
                    'Jumlah melebihi stok yang tersedia!'
                );

            }

        } else {

            cart.push({
                id,
                nama,
                harga,
                stok,
                qty: 1
            });

        }

        renderCart();

    }


    // ==========================================
    // UPDATE QTY ITEM
    // ==========================================

    function updateQty(id, newQty) {

        const item = cart.find(
            i => i.id === id
        );

        if (item) {

            if (newQty > item.stok) {

                alert(
                    'Jumlah melebihi stok tersedia!'
                );

                item.qty = item.stok;

            } else if (newQty <= 0) {

                removeFromCart(id);

                return;

            } else {

                item.qty = parseInt(newQty);

            }

        }

        renderCart();

    }


    // ==========================================
    // HAPUS ITEM
    // ==========================================

    function removeFromCart(id) {

        cart = cart.filter(
            item => item.id !== id
        );

        renderCart();

    }


    // ==========================================
    // KOSONGKAN KERANJANG
    // ==========================================

    function clearCart() {

        cart = [];

        renderCart();

    }


    // ==========================================
    // RENDER TABEL & INPUT HIDDEN
    // ==========================================

    function renderCart() {

        const tbody =
            document.getElementById(
                'cartTableBody'
            );

        tbody.innerHTML = '';


        if (cart.length === 0) {

            tbody.innerHTML = `
                <tr id="emptyCartRow">

                    <td
                        colspan="4"
                        class="text-center py-4 text-slate-400 small"
                    >
                        Keranjang masih kosong.
                        <br>
                        Klik produk di sebelah kiri.
                    </td>

                </tr>
            `;

            document.getElementById(
                'displayTotal'
            ).innerText = 'Rp 0';

            document.getElementById(
                'btnSubmit'
            ).disabled = true;

            currentGrandTotal = 0;

            return;
        }


        let grandTotal = 0;


        cart.forEach((item, index) => {

            const subtotal =
                item.harga * item.qty;

            grandTotal += subtotal;


            const tr =
                document.createElement('tr');


            tr.innerHTML = `

                <td>

                    <span
                        class="fw-semibold text-white d-block text-truncate"
                        style="max-width: 120px;"
                    >
                        ${item.nama}
                    </span>

                    <small class="text-slate-400">
                        @ Rp ${item.harga.toLocaleString('id-ID')}
                    </small>

                    <input
                        type="hidden"
                        name="items[${index}][produk_id]"
                        value="${item.id}"
                    >

                    <input
                        type="hidden"
                        name="items[${index}][harga]"
                        value="${item.harga}"
                    >

                </td>


                <td class="text-center">

                    <input
                        type="number"
                        name="items[${index}][qty]"
                        class="form-control form-control-sm form-control-dark text-center px-1"
                        value="${item.qty}"
                        min="1"
                        max="${item.stok}"
                        onchange="updateQty(${item.id}, this.value)"
                    >

                </td>


                <td
                    class="text-end font-monospace fw-bold"
                    style="color: #34d399;"
                >
                    Rp ${subtotal.toLocaleString('id-ID')}
                </td>


                <td class="text-center">

                    <button
                        type="button"
                        class="btn btn-sm text-danger p-0"
                        onclick="removeFromCart(${item.id})"
                    >

                        <i class="bi bi-x-circle"></i>

                    </button>

                </td>

            `;

            tbody.appendChild(tr);

        });


        currentGrandTotal = grandTotal;


        document.getElementById(
            'displayTotal'
        ).innerText =
            'Rp ' +
            grandTotal.toLocaleString('id-ID');


        document.getElementById(
            'btnSubmit'
        ).disabled = false;

    }


    // ==========================================
    // CHECKOUT / QRIS
    // ==========================================

    function handleCheckout() {

        const metode =
            document.getElementById(
                'metodePembayaran'
            ).value;


        if (metode === 'QRIS') {

            document.getElementById(
                'qrisTotalDisplay'
            ).innerText =
                'Rp ' +
                currentGrandTotal.toLocaleString(
                    'id-ID'
                );


            const qrisModal =
                new bootstrap.Modal(
                    document.getElementById(
                        'modalQris'
                    )
                );


            qrisModal.show();

        } else {

            submitFormDirectly();

        }

    }


    // ==========================================
    // SUBMIT FORM
    // ==========================================

    function submitFormDirectly() {

        document
            .getElementById('formKasir')
            .submit();

    }

</script>

@endsection