 <?php $__env->startSection('content'); ?>
    <h2>Daftar Gudang (Warehouse)</h2>
    <!-- <a href="<?php echo e(route('warehouses.create')); ?>" class="btn btn-primary mb-3">+ Tambah Gudang</a> -->
    <a href="/warehouses/create" class="btn btn-primary mb-3">+ Tambah Gudang</a>


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
            <th>Lokasi</th>
            <th>Aksi</th>
        </tr>
        <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($warehouse->name); ?></td>
                <td><?php echo e($warehouse->location); ?></td>
                <td>
                    <a href="<?php echo e(route('warehouses.edit', $warehouse->id)); ?>" class="btn btn-warning btn-sm">Edit</a>

                    <form action="<?php echo e(route('warehouses.destroy', $warehouse->id)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus Gudang ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>

    <?php echo e($warehouses->links()); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\KULIAH\Semester 3\Lab Web\Pengerjaan\Praktikum-9\resources\views/warehouses/index.blade.php ENDPATH**/ ?>