<?php $__env->startSection('title', 'Tambah Produk Baru'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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
            font-family: 'Plus Jakarta Sans', 'Instrument Sans', system-ui, -apple-system, sans-serif;
        }

        /* CARD */
        .card-pro {
            background: var(--card-bg) !important;
            border: 1px solid var(--card-border);
            border-radius: 1.25rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }

        /* INPUT & SELECT */
        .form-control-dark,
        .form-select-dark {
            background-color: #0f172a !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #f8fafc !important;
            border-radius: 0.75rem !important;
            padding: 0.7rem 1rem;
        }

        .form-control-dark:focus,
        .form-select-dark:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25) !important;
        }

        /* SELECT OPTION */
        .form-select-dark option {
            background-color: #0f172a;
            color: #f8fafc;
            padding: 8px;
        }

        /* LABEL */
        .form-label-dark {
            color: #cbd5e1 !important;
        }

        /* PLACEHOLDER */
        .form-control-dark::placeholder {
            color: #64748b !important;
            opacity: 1 !important;
        }

        /* RP INPUT */
        .input-group-text-dark {
            color: #94a3b8 !important;
            background: #0f172a !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        /* FILE INPUT */
        .form-control-dark::file-selector-button {
            background: #334155;
            color: #f8fafc;
            border: none;
            padding: 0.4rem 0.8rem;
            border-radius: 0.5rem;
            margin-right: 0.75rem;
            transition: all 0.2s;
        }

        .form-control-dark::file-selector-button:hover {
            background: #475569;
            cursor: pointer;
        }

        /* IMAGE PREVIEW */
        .image-preview-container {
            width: 100%;
            height: 220px;
            background-color: #0f172a;
            border: 2px dashed rgba(255, 255, 255, 0.15);
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .image-preview-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* BUTTON SAVE */
        .btn-save-pro {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            font-weight: 700;
            border-radius: 0.75rem;
            padding: 0.75rem 1.75rem;
            border: none;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4);
            transition: all 0.25s ease;
        }

        .btn-save-pro:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
            color: #ffffff;
        }

        /* BUTTON BACK */
        .btn-back-pro {
            background: rgba(148, 163, 184, 0.15);
            color: #cbd5e1;
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-weight: 600;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-back-pro:hover {
            background: rgba(148, 163, 184, 0.25);
            color: #ffffff;
        }

        /* ERROR */
        .text-error {
            color: #f87171;
            font-size: 0.8rem;
            margin-top: 0.4rem;
        }

        /* REQUIRED */
        .required {
            color: #ef4444;
        }
    </style>

    <div class="container py-5">

        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-black text-white mb-1"
                    style="font-size: 2rem; letter-spacing: -0.02em;">
                    Tambah Produk Baru
                </h1>

                <p class="mb-0 small" style="color: #94a3b8;">
                    Isi formulir berikut untuk menambahkan stok barang ke dalam sistem.
                </p>
            </div>

            <div>
                <a href="<?php echo e(route('produk.index')); ?>"
                    class="btn btn-back-pro d-inline-flex align-items-center gap-2">

                    <i class="bi bi-arrow-left"></i>
                    Kembali

                </a>
            </div>
        </div>


        
        <?php if($errors->any()): ?>
            <div class="alert alert-danger mb-4">
                <strong>Terjadi kesalahan:</strong>

                <ul class="mb-0 mt-2">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>


        
        <div class="card card-pro p-4 p-md-5">

            <form action="<?php echo e(route('produk.store')); ?>"
                method="POST"
                enctype="multipart/form-data">

                <?php echo csrf_field(); ?>

                <div class="row g-4">

                    
                    
                    
                    <div class="col-12 col-lg-7">

                        
                        <div class="mb-3">

                            <label class="form-label fw-bold small form-label-dark">
                                Nama Produk
                                <span class="required">*</span>
                            </label>

                            <input type="text"
                                name="nama"
                                class="form-control form-control-dark <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="Contoh: Kopi Susu Aren"
                                value="<?php echo e(old('nama')); ?>"
                                required>

                            <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-error">
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        </div>


                        
                        
                        
                        <div class="mb-3">

                            <label class="form-label fw-bold small form-label-dark">
                                Jenis Produk
                                <span class="required">*</span>
                            </label>

                            <select name="jenis_produk"
                                id="jenisProduk"
                                class="form-select form-select-dark <?php $__errorArgs = ['jenis_produk'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required>

                                <option value=""
                                    disabled
                                    <?php echo e(old('jenis_produk') ? '' : 'selected'); ?>>
                                    Pilih jenis produk
                                </option>

                                
                                <?php $__currentLoopData = $jenis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <option value="<?php echo e($item->nama_jenis); ?>"
                                        <?php echo e(old('jenis_produk') == $item->nama_jenis ? 'selected' : ''); ?>>

                                        📦 <?php echo e($item->nama_jenis); ?>


                                    </option>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>

                            <?php $__errorArgs = ['jenis_produk'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-error">
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        </div>


                        
                        
                        
                        <div class="row mb-3">

                            
                            <div class="col-12 col-md-6 mb-3 mb-md-0">

                                <label class="form-label fw-bold small form-label-dark">
                                    Harga Beli (Rp)
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text input-group-text-dark"
                                        style="border-radius: 0.75rem 0 0 0.75rem !important;">
                                        Rp
                                    </span>

                                    <input type="number"
                                        name="harga_beli"
                                        class="form-control form-control-dark border-start-0 <?php $__errorArgs = ['harga_beli'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="0"
                                        value="<?php echo e(old('harga_beli')); ?>"
                                        min="0"
                                        style="border-radius: 0 0.75rem 0.75rem 0 !important;">

                                </div>

                                <?php $__errorArgs = ['harga_beli'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-error">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>


                            
                            <div class="col-12 col-md-6">

                                <label class="form-label fw-bold small form-label-dark">
                                    Harga Jual (Rp)
                                    <span class="required">*</span>
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text input-group-text-dark"
                                        style="border-radius: 0.75rem 0 0 0.75rem !important;">
                                        Rp
                                    </span>

                                    <input type="number"
                                        name="harga_jual"
                                        class="form-control form-control-dark border-start-0 <?php $__errorArgs = ['harga_jual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="0"
                                        value="<?php echo e(old('harga_jual')); ?>"
                                        min="0"
                                        required
                                        style="border-radius: 0 0.75rem 0.75rem 0 !important;">

                                </div>

                                <?php $__errorArgs = ['harga_jual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-error">
                                        <?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            </div>

                        </div>


                        
                        
                        
                        <div class="mb-4">

                            <label class="form-label fw-bold small form-label-dark">
                                Jumlah Stok
                                <span class="required">*</span>
                            </label>

                            <input type="number"
                                name="stok"
                                class="form-control form-control-dark <?php $__errorArgs = ['stok'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                placeholder="0"
                                value="<?php echo e(old('stok', 0)); ?>"
                                min="0"
                                required>

                            <?php $__errorArgs = ['stok'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-error">
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        </div>

                    </div>


                    
                    
                    
                    <div class="col-12 col-lg-5 d-flex flex-column justify-content-between">

                        <div>

                            
                            <label class="form-label fw-bold small form-label-dark">
                                Foto Produk
                            </label>


                            
                            <div class="image-preview-container mb-3"
                                id="previewBox">

                                <div class="text-center p-3"
                                    id="previewPlaceholder"
                                    style="color: #64748b;">

                                    <i class="bi bi-cloud-arrow-up fs-1 d-block mb-1"></i>

                                    <span class="small fw-semibold">
                                        Preview Foto Produk
                                    </span>

                                </div>

                                <img id="imgPreview"
                                    class="d-none"
                                    alt="Preview Gambar">

                            </div>


                            
                            <input type="file"
                                name="foto"
                                id="fotoInput"
                                class="form-control form-control-dark <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                accept="image/jpeg,image/png,image/webp"
                                onchange="previewImage(this)">

                            <small class="d-block mt-2"
                                style="color: #64748b;">
                                Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                            </small>

                            <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-error">
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        </div>


                        
                        
                        
                        <div class="d-flex gap-2 justify-content-end mt-4 pt-3"
                            style="border-top: 1px solid rgba(255,255,255,0.08);">

                            <a href="<?php echo e(route('produk.index')); ?>"
                                class="btn btn-back-pro">

                                Batal

                            </a>

                            <button type="submit"
                                class="btn btn-save-pro d-inline-flex align-items-center gap-2">

                                <i class="bi bi-floppy-fill"></i>

                                Simpan Produk

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    
    
    
    <script>
        function previewImage(input) {

            const preview = document.getElementById('imgPreview');
            const placeholder = document.getElementById('previewPlaceholder');

            if (input.files && input.files[0]) {

                const file = input.files[0];

                // Cek ukuran file maksimal 2 MB
                if (file.size > 2 * 1024 * 1024) {

                    alert('Ukuran foto maksimal 2 MB.');

                    input.value = '';

                    preview.src = '#';
                    preview.classList.add('d-none');

                    placeholder.classList.remove('d-none');

                    return;
                }

                const reader = new FileReader();

                reader.onload = function(e) {

                    preview.src = e.target.result;

                    preview.classList.remove('d-none');

                    placeholder.classList.add('d-none');
                };

                reader.readAsDataURL(file);

            } else {

                preview.src = '#';

                preview.classList.add('d-none');

                placeholder.classList.remove('d-none');
            }
        }
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\APK_ALFADZ-main\resources\views/produk/create.blade.php ENDPATH**/ ?>