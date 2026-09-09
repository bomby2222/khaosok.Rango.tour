

<?php $__env->startSection('header', 'Manage Hero Banners (3 Slides)'); ?>

<?php $__env->startSection('content'); ?>
    <div class="bg-neutral-900 rounded-3xl border border-neutral-800 p-6 sm:p-8 shadow-xl">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="text-lg font-bold text-white">Hero Slider Images</h3>
                <p class="text-xs text-neutral-400 mt-1">Upload and manage rotating banners displayed on the homepage.</p>
            </div>
            <a href="<?php echo e(route('admin.banners.create')); ?>" class="bg-emerald-600 hover:bg-emerald-500 text-neutral-950 font-black text-xs uppercase px-5 py-2.5 rounded-xl transition">
                + Upload New Banner
            </a>
        </div>

        <?php if($banners->isEmpty()): ?>
            <div class="text-center py-12 border border-dashed border-neutral-800 rounded-2xl">
                <p class="text-xs text-neutral-400">No custom banners uploaded. Default slides are active.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-neutral-950 rounded-2xl overflow-hidden border border-neutral-800 shadow-md flex flex-col justify-between">
                        <div>
                            <img src="<?php echo e(asset('storage/' . $banner->image)); ?>" class="w-full h-44 object-cover">
                            <div class="p-4">
                                <h4 class="font-bold text-white text-sm"><?php echo e($banner->title); ?></h4>
                                <p class="text-xs text-neutral-400 mt-1 line-clamp-2"><?php echo e($banner->subtitle); ?></p>
                            </div>
                        </div>
                        <div class="p-4 pt-0 flex justify-end">
                            <form action="<?php echo e(route('admin.banners.destroy', $banner->id)); ?>" method="POST" onsubmit="return confirm('Delete this banner slide?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-rose-400 hover:text-rose-300 text-xs font-bold">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\rango-tour\resources\views/admin/banners/index.blade.php ENDPATH**/ ?>