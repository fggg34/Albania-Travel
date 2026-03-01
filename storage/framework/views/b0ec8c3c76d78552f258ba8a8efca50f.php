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
        : null;

    $wordCount = str_word_count(strip_tags($post->content ?? $post->excerpt ?? ''));
    $readTime  = max(1, (int) ceil($wordCount / 200));
?>

<article class="group bg-white rounded-2xl overflow-hidden relative flex flex-col border border-gray-100 hover:border-gray-200 hover:shadow-xl transition-all duration-300">

    
    <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="block relative overflow-hidden bg-gray-100" style="aspect-ratio: 16/9;">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imageUrl): ?>
        <img src="<?php echo e($imageUrl); ?>" alt="<?php echo e($post->title); ?>"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
        <?php else: ?>
        <div class="w-full h-full bg-gradient-to-br from-[#0f1a1a] to-[#0D9488]/30 flex items-center justify-center">
            <i class="fa-solid fa-newspaper text-white/20 text-4xl"></i>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->category): ?>
        <!-- <div class="absolute top-4 left-4">
            <a href="<?php echo e(route('blog.index', ['category' => $post->category->slug])); ?>"
               class="inline-flex items-center gap-1.5 bg-[#0f1a1a]/75 backdrop-blur-sm text-teal-400 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider hover:bg-[#0D9488] hover:text-white transition-colors">
                <?php echo e($post->category->name); ?>

            </a>
        </div> -->
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </a>

    
    <div class="flex flex-col flex-1 p-6">

        
        <div class="flex items-center gap-2 text-xs text-gray-400 mb-4">
            <i class="fa-regular fa-calendar text-gray-300"></i>
            <span><?php echo e($post->published_at?->format('d M Y')); ?></span>
            <span class="w-1 h-1 rounded-full bg-gray-200 flex-shrink-0"></span>
            <i class="fa-regular fa-clock text-gray-300"></i>
            <span><?php echo e($readTime); ?> min read</span>
        </div>

        
        <a href="<?php echo e(route('blog.show', $post->slug)); ?>" class="block flex-1 mb-4">
            <h3 class="text-base font-bold text-gray-900 leading-snug line-clamp-2 mb-2 group-hover:text-[#0D9488] transition-colors duration-200">
                <?php echo e($post->title); ?>

            </h3>
            <p class="text-sm text-gray-400 leading-relaxed line-clamp-2">
                <?php echo e(Str::limit(strip_tags($post->excerpt ?? ''), 110)); ?>

            </p>
        </a>

        
        <div class="flex items-center justify-between pt-5 border-t border-gray-100 mt-auto">
            <a href="<?php echo e(route('blog.show', $post->slug)); ?>"
               class="inline-flex items-center gap-2 text-sm font-semibold text-[#0D9488]">
                Read article
                <span class="w-6 h-6 rounded-full bg-[#0D9488]/10 group-hover:bg-[#0D9488] group-hover:text-white flex items-center justify-center transition-all duration-300">
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </span>
            </a>
        </div>
    </div>
</article>
<?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOURS Second/resources/views/components/blog-card.blade.php ENDPATH**/ ?>