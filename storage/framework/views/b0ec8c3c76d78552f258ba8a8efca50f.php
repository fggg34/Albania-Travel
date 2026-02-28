<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['post']));

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

foreach (array_filter((['post']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $imageUrl = $post->featured_image
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($post->featured_image)
        : 'https://placehold.co/600x400/e5e7eb/6b7280?text=Blog';
?>

<article class="group bg-white rounded-2xl overflow-hidden border border-gray-100 hover:shadow-xl hover:border-gray-200 transition-all duration-300 flex flex-col">
    <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="block">
        <div class="aspect-[16/10] overflow-hidden bg-gray-100">
            <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($post->title); ?>"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </div>
    </a>
    <div class="p-6 flex flex-col flex-1">
        
        <div class="flex items-center gap-3 mb-3">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->category): ?>
            <a href="<?php echo e(route('blog.index', ['category' => $post->category->slug])); ?>"
               class="text-xs font-semibold text-[#0D9488] uppercase tracking-wide hover:underline">
                <?php echo e($post->category->name); ?>

            </a>
            <span class="text-gray-200">·</span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <span class="text-xs text-gray-400"><?php echo e($post->published_at?->format('d M Y')); ?></span>
        </div>

        
        <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="block">
            <h3 class="text-base font-bold text-gray-900 leading-snug line-clamp-2 mb-3 group-hover:text-[#0D9488] transition-colors">
                <?php echo e($post->title); ?>

            </h3>
        </a>

        
        <p class="text-sm text-gray-500 leading-relaxed line-clamp-2 flex-1">
            <?php echo e(Str::limit(strip_tags($post->excerpt ?? ''), 120)); ?>

        </p>

        
        <a href="<?php echo e(route('blog.show', $post->slug)); ?>"
           class="inline-flex items-center gap-1.5 mt-5 text-sm font-semibold text-[#0D9488] hover:gap-2.5 transition-all">
            Read article <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
    </div>
</article>
<?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOURS Second/resources/views/components/blog-card.blade.php ENDPATH**/ ?>