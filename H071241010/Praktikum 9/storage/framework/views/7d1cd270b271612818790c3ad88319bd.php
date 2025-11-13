     <?php $__env->startSection('content'); ?>
    <h2>Daftar Produk</h2>

    <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary mb-3">+ Tambah Produk</a>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th> <th>Harga</th>
                <th>Berat (kg)</th> <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($product->name); ?></td>
                
                <td><?php echo e($product->category ? $product->category->name : 'N/A'); ?></td>
                
                <td>Rp <?php echo e(number_format($product->price, 2, ',', '.')); ?></td>
                
                <td><?php echo e($product->detail ? $product->detail->weight : 'N/A'); ?></td>
                
                <td>
                    <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="btn btn-warning btn-sm">Edit</a>
                    
                    <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus Produk ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <?php echo e($products->links()); ?>


    <?php $__env->stopSection(); ?> 

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\HP\KULIAH\Semester 3\Lab Web\Pengerjaan\Praktikum-9\resources\views/products/index.blade.php ENDPATH**/ ?>