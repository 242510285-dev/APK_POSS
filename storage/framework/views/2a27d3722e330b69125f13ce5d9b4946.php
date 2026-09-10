<?php $__env->startSection('title', 'Edit Jenis'); ?>

<?php $__env->startSection('content'); ?>

<style>

    body {
        background: #080d19;
        color: white;
    }

    .form-page {
        max-width: 750px;
        margin: 40px auto;
    }

    .form-card {
        background: #111827;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 15px 40px rgba(0,0,0,.25);
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        color: white;
    }

    .page-description {
        color: #64748b;
    }

    .form-label {
        color: #cbd5e1;
        font-weight: 600;
    }

    .form-control {
        background: #0f172a !important;
        border: 1px solid #334155 !important;
        color: white !important;
        padding: 12px;
        border-radius: 6px;
    }

    .form-control::placeholder {
        color: #64748b;
    }

    .form-control:focus {
        background: #0f172a !important;
        color: white !important;
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 .2rem rgba(99,102,241,.15);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 130px;
    }

    .btn-save {
        background: #6366f1;
        border: none;
        color: white;
        font-weight: 700;
        padding: 11px 20px;
        border-radius: 8px;
        cursor: pointer;
        transition: .2s;
    }

    .btn-save:hover {
        background: #4f46e5;
        color: white;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        background: #334155;
        color: white;
        padding: 11px 20px;
        border-radius: 8px;
        text-decoration: none;
        transition: .2s;
    }

    .btn-back:hover {
        background: #475569;
        color: white;
    }

    .text-danger {
        font-size: 13px;
        color: #f87171 !important;
    }

    .alert-danger {
        background: #f8d7da;
        border: 1px solid #f1aeb5;
        color: #842029;
        border-radius: 6px;
        padding: 12px 16px;
    }

</style>


<div class="container form-page">

    <div class="form-card">

        
        <h1 class="page-title mb-2">

            <i class="bi bi-pencil-square me-2"></i>

            Edit Jenis

        </h1>


        <p class="page-description mb-4">

            Ubah informasi jenis produk.

        </p>


        
        <?php if($errors->any()): ?>

            <div class="alert alert-danger mb-4">

                <ul class="mb-0">

                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <li>
                            <?php echo e($error); ?>

                        </li>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </ul>

            </div>

        <?php endif; ?>


        
        <form
            action="<?php echo e(route('jenis.update', $jenis->id)); ?>"
            method="POST"
        >

            <?php echo csrf_field(); ?>

            <?php echo method_field('PUT'); ?>


            
            <div class="mb-3">

                <label
                    for="nama_jenis"
                    class="form-label"
                >

                    Nama Jenis

                    <span class="text-danger">*</span>

                </label>


                <input
                    type="text"
                    id="nama_jenis"
                    name="nama_jenis"
                    class="form-control <?php $__errorArgs = ['nama_jenis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    value="<?php echo e(old('nama_jenis', $jenis->nama_jenis)); ?>"
                    placeholder="Contoh: Makanan"
                    required
                >


                <?php $__errorArgs = ['nama_jenis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                    <div class="text-danger mt-1">

                        <?php echo e($message); ?>


                    </div>

                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            </div>


            
            <div class="mb-4">

                <label
                    for="deskripsi"
                    class="form-label"
                >

                    Deskripsi

                </label>


                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    class="form-control <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    rows="5"
                    placeholder="Contoh: Jenis produk makanan dan minuman..."
                ><?php echo e(old('deskripsi', $jenis->deskripsi)); ?></textarea>


                <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>

                    <div class="text-danger mt-1">

                        <?php echo e($message); ?>


                    </div>

                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            </div>


            
            <div class="d-flex gap-2">

                <a
                    href="<?php echo e(route('jenis.index')); ?>"
                    class="btn-back"
                >

                    <i class="bi bi-arrow-left me-1"></i>

                    Kembali

                </a>


                <button
                    type="submit"
                    class="btn-save"
                >

                    <i class="bi bi-save me-1"></i>

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\APK_ALFADZ-main\resources\views/jenis/edit.blade.php ENDPATH**/ ?>