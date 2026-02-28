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
        : ($tour->duration_hours ? $tour->duration_hours . ' hrs' : null);
    $startTimeFormatted = $tour->start_time
        ? \Carbon\Carbon::parse($tour->start_time)->format('g:i A')
        : null;
?>

<article <?php echo e($attributes->merge(['class' => 'group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl hover:border-gray-200 transition-all duration-300' . ($slider ? ' flex-shrink-0 w-[300px]' : '')])); ?>

         <?php if($slider): ?> data-slider-card <?php endif; ?>>
    <a href="<?php echo e($tourUrl); ?>" class="block">

        
        <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
            <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($tour->title); ?>"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($durationLabel): ?>
            <span class="absolute bottom-3 left-3 px-2.5 py-1 bg-black/60 backdrop-blur-sm text-white text-xs font-semibold rounded-full">
                <i class="fa-regular fa-clock mr-1"></i><?php echo e($durationLabel); ?>

            </span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($wishlisted): ?>
                    <form method="POST" action="<?php echo e(route('wishlist.destroy', $tour)); ?>"
                          class="absolute top-3 right-3 z-10" onclick="event.stopPropagation()">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit"
                                class="w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-rose-500 hover:bg-white transition shadow-sm"
                                aria-label="Remove from wishlist">
                            <i class="fa-solid fa-heart text-xs"></i>
                        </button>
                    </form>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('wishlist.store', $tour)); ?>"
                          class="absolute top-3 right-3 z-10" onclick="event.stopPropagation()">
                        <?php echo csrf_field(); ?>
                        <button type="submit"
                                class="w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-gray-400 hover:text-rose-500 hover:bg-white transition shadow-sm"
                                aria-label="Add to wishlist">
                            <i class="fa-regular fa-heart text-xs"></i>
                        </button>
                    </form>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="p-5">

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->start_location): ?>
            <p class="text-xs text-gray-400 mb-2 flex items-center gap-1.5 truncate">
                <i class="fa-solid fa-location-dot text-[#0D9488] text-[10px]"></i>
                <?php echo e($tour->start_location); ?>

            </p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <h3 class="text-base font-bold text-gray-900 leading-snug line-clamp-2 mb-4"><?php echo e($tour->title); ?></h3>

            
            <div class="flex items-center gap-3 text-xs text-gray-500 mb-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($startTimeFormatted): ?>
                <span class="flex items-center gap-1">
                    <i class="fa-regular fa-clock"></i> <?php echo e($startTimeFormatted); ?>

                </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tour->end_location && $tour->end_location !== $tour->start_location): ?>
                <span class="flex items-center gap-1 truncate">
                    <i class="fa-solid fa-flag-checkered"></i>
                    <span class="truncate"><?php echo e($tour->end_location); ?></span>
                </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                <div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rating): ?>
                    <div class="flex items-center gap-1">
                        <?php if (isset($component)) { $__componentOriginaldd1cac021a1037a3ad586e7a83aa8b85 = $component; } ?>
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
<?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reviewCount): ?>
                        <span class="text-xs text-gray-400 ml-0.5">(<?php echo e($reviewCount); ?>)</span>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <?php else: ?>
                    <span class="text-xs text-gray-400">No reviews yet</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="text-right">
                    <span class="text-xs text-gray-400">From</span>
                    <span class="block text-lg font-bold text-[#0D9488] leading-tight">€<?php echo e(number_format($tour->price ?? 0, 0)); ?></span>
                </div>
            </div>

        </div>
    </a>
</article>
<?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOURS Second/resources/views/components/tour-card.blade.php ENDPATH**/ ?>