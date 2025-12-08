 <?php $__env->startSection('content'); ?> <h2>Daftar Kategori</h2>

<a href="<?php echo e(route('categories.create')); ?>" class="btn btn-primary mb-3">+ Tambah Kategori</a>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
<?php endif; ?>

<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Deskripsi</th> <th>Aksi</th>
    </tr>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td><?php echo e($loop->iteration); ?></td>
        <td><?php echo e($category->name); ?></td>
        <td><?php echo e($category->description); ?></td> <td>
            <a href="<?php echo e(route('categories.edit', $category->id)); ?>" class="btn btn-warning btn-sm">Edit</a>
            
            <form action="<?php echo e(route('categories.destroy', $category->id)); ?>" method="POST" style="display:inline;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus Kategori ini?')">Hapus</button>
            </form>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>

<?php echo e($categories->links()); ?>


<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\KULIAH\Semester 3\Lab Web\Pengerjaan\Praktikum-9\resources\views/categories/index.blade.php ENDPATH**/ ?>