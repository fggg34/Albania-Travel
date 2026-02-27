<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['tour', 'queryParams' => [], 'wishlisted' => false, 'slider' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['tour', 'queryParams' => [], 'wishlisted' => false, 'slider' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $firstImg = $tour->images->first();
    $imageUrl = $firstImg?->url ?? 'https://placehold.co/600x400/e5e7eb/6b7280?text=Tour';
    $rating = $tour->average_rating ?? $tour->approvedReviews->avg('rating');
    $reviewCount = $tour->approvedReviews->count();
    $tourUrl = route('tours.show', $tour->slug);
    if (!empty($queryParams)) {
        $tourUrl .= '?' . http_build_query($queryParams);
    }
    $durationLabel = $tour->duration_days
        ? $tour->duration_days . ' day' . ($tour->duration_days > 1 ? 's' : '')
        : ($tour->duration_hours ? $tour->duration_hours . ' hours' : null);
    $startTimeFormatted = $tour->start_time
        ? \Carbon\Carbon::parse($tour->start_time)->format('g:i A')
        : null;
?>
<article
    <?php echo e($attributes->merge(['class' => 'bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300' . ($slider ? ' flex-shrink-0 w-[300px]' : '')])); ?>

    <?php if($slider): ?> data-slider-card <?php endif; ?>
>
    <a href="<?php echo e($tourUrl); ?>" class="block">
        <div class="relative aspect-[4/3] overflow-hidden bg-gray-200">
            <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($tour->title); ?>" class="w-full h-full object-cover">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($wishlisted): ?>
                    <form method="POST" action="<?php echo e(route('wishlist.destroy', $tour)); ?>" class="absolute top-3 right-3 z-10" onclick="event.stopPropagation()">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="w-9 h-9 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-rose-500 hover:bg-white transition-colors" aria-label="Remove from wishlist">
                            <i class="fa-solid fa-heart"></i>
                        </button>
                    </form>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('wishlist.store', $tour)); ?>" class="absolute top-3 right-3 z-10" onclick="event.stopPropagation()">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-9 h-9 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-gray-600 hover:text-rose-500 hover:bg-white transition-colors" aria-label="Add to wishlist">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    </form>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div class="p-4">
            <h3 class="text-base font-bold text-gray-900 line-clamp-2 leading-snug"><?php echo e($tour->title); ?></h3>

            
            <div class="mt-3 grid grid-cols-2 gap-3">
                <div class="flex gap-2">
                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-flag text-slate-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-gray-600">Tour starts</p>
                        <p class="text-xs text-sky-600 truncate" title="<?php echo e($tour->start_location); ?>"><?php echo e($tour->start_location ?: '—'); ?></p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                        <i class="fa-regular fa-clock text-slate-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-gray-600">Starting time</p>
                        <p class="text-xs text-sky-600"><?php echo e($startTimeFormatted ?: 'Flexible'); ?></p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-sun text-slate-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-gray-600">Duration</p>
                        <p class="text-xs text-sky-600"><?php echo e($durationLabel ?: '—'); ?></p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-suitcase text-slate-600 text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-gray-600">Ending place</p>
                        <p class="text-xs text-sky-600 truncate" title="<?php echo e($tour->end_location); ?>"><?php echo e($tour->end_location ?: ($tour->start_location ?: '—')); ?></p>
                    </div>
                </div>
            </div>

            <div class="mt-3 flex items-center justify-between gap-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rating || $reviewCount): ?>
                    <p class="flex items-center gap-1 text-sm text-gray-600">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rating): ?><?php if (isset($component)) { $__componentOriginaldd1cac021a1037a3ad586e7a83aa8b85 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldd1cac021a1037a3ad586e7a83aa8b85 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.review-stars','data' => ['rating' => (float) $rating]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('review-stars'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['rating' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute((float) $rating)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldd1cac021a1037a3ad586e7a83aa8b85)): ?>
<?php $attributes = $__attributesOriginaldd1cac021a1037a3ad586e7a83aa8b85; ?>
<?php unset($__attributesOriginaldd1cac021a1037a3ad586e7a83aa8b85); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldd1cac021a1037a3ad586e7a83aa8b85)): ?>
<?php $component = $__componentOriginaldd1cac021a1037a3ad586e7a83aa8b85; ?>
<?php unset($__componentOriginaldd1cac021a1037a3ad586e7a83aa8b85); ?>
<?php endif; ?><?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <span class="text-gray-500">(<?php echo e(number_format($reviewCount)); ?>)</span>
                    </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="flex items-baseline gap-1 ml-auto">
                    <span class="text-sm text-gray-500">From</span>
                    <span class="text-lg font-bold text-rose-600">€<?php echo e(number_format($tour->price ?? 0, 0)); ?></span>
                </div>
            </div>
        </div>
    </a>
</article>
<?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOURS Second/resources/views/components/tour-card.blade.php ENDPATH**/ ?>