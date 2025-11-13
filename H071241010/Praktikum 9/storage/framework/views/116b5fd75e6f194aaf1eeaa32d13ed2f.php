 <?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Manajemen Stok</h2>
    <a href="<?php echo e(route('stocks.transfer.create')); ?>" class="btn btn-success">+ Transfer Stok</a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
<?php endif; ?>

<div class="card mb-4">
    <div class="card-header">Filter Stok Gudang</div>
    <div class="card-body">
        <form action="<?php echo e(route('stocks.index')); ?>" method="GET">
            <div class="row">
                <div class="col-md-10">
                    <select name="warehouse_id" class="form-select" required>
                        <option value="">-- Pilih Gudang untuk Menampilkan Stok --</option>
                        <?php $__currentLoopData = $warehouses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warehouse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($warehouse->id); ?>"
                                <?php if($warehouse->id == $selectedWarehouseId): ?> selected <?php endif; ?>
                            >
                                <?php echo e($warehouse->name); ?> (<?php echo e($warehouse->location); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php if($selectedWarehouseId): ?>
    <div class="card">
        <div class="card-header">Daftar Stok</div>
        <div class="card-body">
            <?php if($productsInWarehouse && $productsInWarehouse->count() > 0): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>Jumlah Stok Saat Ini</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $productsInWarehouse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($product->name); ?></td>
                            <td><strong><?php echo e($product->pivot->quantity); ?></strong> unit</td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">Tidak ada stok produk di gudang ini.</p>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-info">
        Silakan pilih gudang di atas untuk melihat daftar stok.
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\KULIAH\Semester 3\Lab Web\Pengerjaan\Praktikum-9\resources\views/stocks/index.blade.php ENDPATH**/ ?>