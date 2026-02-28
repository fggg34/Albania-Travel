<?php $__env->startSection('title', \App\Models\Setting::get('site_name', config('app.name')) . ' - ' . \App\Models\Setting::get('site_tagline', 'Discover your next adventure')); ?>
<?php $__env->startSection('description', \App\Models\Setting::get('hero_subtitle', 'Explore stunning destinations with expert guides.')); ?>

<?php $__env->startSection('hero'); ?>
<?php
    $hero = $hero ?? null;
    $heroTitle = $hero?->title ?? \App\Models\Setting::get('hero_title', 'Adventure Simplified');
    $heroSubtitle = $hero?->subtitle ?? \App\Models\Setting::get('hero_subtitle', 'Guides, local transport, accommodation, and like-minded travelers are always included. Book securely & flexibly.');
    $bgImage = $hero && $hero->banner_type === 'image' && $hero->banner_image ? $hero->banner_image_url : 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1920';
    $bgVideo = $hero && $hero->banner_type === 'video' && $hero->banner_video ? $hero->banner_video_url : null;
?>
<section class="relative w-full rounded-b-3xl md:rounded-b-[2rem] min-h-[420px] md:min-h-[520px] flex flex-col justify-center items-center text-white" style="min-height: calc(100vh - 120px);">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bgVideo): ?>
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="<?php echo e($bgVideo); ?>" type="video/mp4">
        </video>
    <?php else: ?>
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo e($bgImage); ?>');"></div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <div class="absolute inset-0 bg-black/50"></div>
    <div class="relative z-10 w-full max-w-5xl mx-auto px-4 text-center pt-12 pb-8 flex flex-col items-center flex-1 justify-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-8 drop-shadow-sm"><?php echo e($heroTitle); ?></h1>
        <p class="text-lg md:text-xl text-white/95 max-w-5xl mb-8 drop-shadow-sm"><?php echo e($heroSubtitle); ?></p>
        <div class="w-full mt-4 pb-4">
            <?php if (isset($component)) { $__componentOriginal91144834ae340585ab8bc428a53a6d32 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91144834ae340585ab8bc428a53a6d32 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.hero-search-form','data' => ['action' => route('tours.index'),'cities' => $cities ?? collect()]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('hero-search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('tours.index')),'cities' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($cities ?? collect())]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91144834ae340585ab8bc428a53a6d32)): ?>
<?php $attributes = $__attributesOriginal91144834ae340585ab8bc428a53a6d32; ?>
<?php unset($__attributesOriginal91144834ae340585ab8bc428a53a6d32); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91144834ae340585ab8bc428a53a6d32)): ?>
<?php $component = $__componentOriginal91144834ae340585ab8bc428a53a6d32; ?>
<?php unset($__componentOriginal91144834ae340585ab8bc428a53a6d32); ?>
<?php endif; ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($tourInfoPoints) && $tourInfoPoints->isNotEmpty()): ?>
<section class="bg-slate-50/80 py-12 md:py-[20px] border-b border-slate-200/60" style="background-color: #F0F6F3;">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-10">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tourInfoPoints; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-16 h-16 rounded-full bg-white flex items-center justify-center overflow-hidden">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($point->icon): ?>
                    <img src="<?php echo e($point->icon_url); ?>" alt="" class="w-full h-full object-contain" />
                    <?php else: ?>
                    <svg class="w-8 h-8 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-lg" style="color: #41235A;"><?php echo e($point->title); ?></h3>
                    <p class="text-slate-500 text-sm mt-1 leading-relaxed"><?php echo e($point->description); ?></p>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($featuredTours->isNotEmpty()): ?>
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-8">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->get('city') && $cityName = $cities->firstWhere('slug', request()->get('city'))?->name): ?>
            Based on your search in <?php echo e($cityName); ?>

        <?php else: ?>
            Featured Tours
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $featuredTours->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal82db288ae19d37c54da8bf5b2a908f6d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal82db288ae19d37c54da8bf5b2a908f6d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.tour-card','data' => ['tour' => $tour,'queryParams' => [],'wishlisted' => in_array($tour->id, $wishlistedIds ?? []),'slider' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('tour-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tour' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tour),'queryParams' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([]),'wishlisted' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(in_array($tour->id, $wishlistedIds ?? [])),'slider' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal82db288ae19d37c54da8bf5b2a908f6d)): ?>
<?php $attributes = $__attributesOriginal82db288ae19d37c54da8bf5b2a908f6d; ?>
<?php unset($__attributesOriginal82db288ae19d37c54da8bf5b2a908f6d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal82db288ae19d37c54da8bf5b2a908f6d)): ?>
<?php $component = $__componentOriginal82db288ae19d37c54da8bf5b2a908f6d; ?>
<?php unset($__componentOriginal82db288ae19d37c54da8bf5b2a908f6d); ?>
<?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>
</section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($destinationCities) && $destinationCities->isNotEmpty()): ?>
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" x-data="homeSlider({ fixedSlideBy: 6 })">
    <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-8">Things to do wherever you're going</h2>
    <div class="relative flex items-stretch">
        <div class="flex-1 overflow-x-auto scroll-smooth scrollbar-hide" x-ref="track" style="scrollbar-width: none; -ms-overflow-style: none;">
            <div class="flex gap-5 pb-4" style="scroll-snap-type: x mandatory;" data-slider-gap="20">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $destinationCities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <div class="flex-shrink-0" style="scroll-snap-align: start;">
                        <?php if (isset($component)) { $__componentOriginala654b68189fc78604d72908e258b1f1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala654b68189fc78604d72908e258b1f1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.destination-card','data' => ['city' => $city]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('destination-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['city' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($city)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala654b68189fc78604d72908e258b1f1f)): ?>
<?php $attributes = $__attributesOriginala654b68189fc78604d72908e258b1f1f; ?>
<?php unset($__attributesOriginala654b68189fc78604d72908e258b1f1f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala654b68189fc78604d72908e258b1f1f)): ?>
<?php $component = $__componentOriginala654b68189fc78604d72908e258b1f1f; ?>
<?php unset($__componentOriginala654b68189fc78604d72908e258b1f1f); ?>
<?php endif; ?>
                    </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
        <button type="button" @click="scrollNext()" class="flex-shrink-0 w-12 h-12 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center ml-4 hover:bg-sky-200 transition-colors self-center shadow-sm" aria-label="Scroll right">
            <i class="fa-solid fa-chevron-right"></i>
        </button>
    </div>
</section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<section class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-10">Categories</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <a href="<?php echo e(route('tours.index', ['category' => $cat->slug])); ?>" class="block bg-white rounded-xl shadow hover:shadow-md text-center transition overflow-hidden">
                    <div class="aspect-[4/3] w-full overflow-hidden bg-gray-100">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($cat->image_url): ?>
                        <img src="<?php echo e($cat->image_url); ?>" alt="<?php echo e($cat->name); ?>" class="w-full h-full object-cover" loading="lazy" />
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <i class="fa-solid fa-compass text-4xl"></i>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="p-6">
                        <h3 class="font-semibold text-gray-900"><?php echo e($cat->name); ?></h3>
                        <p class="text-sm text-gray-500 mt-1"><?php echo e(Str::limit(strip_tags($cat->description ?? ''), 40)); ?></p>
                    </div>
                </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
</section>

<!-- <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($homepageAbout) && $homepageAbout && $homepageAbout->is_active): ?>
<section class="bg-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-start">
            
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6"><?php echo e($homepageAbout->title); ?></h2>
                <div class="text-gray-600 leading-relaxed prose prose-lg max-w-none">
                    <?php echo nl2br(e($homepageAbout->description ?? '')); ?>

                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4" style="grid-template-rows: auto 1fr;">
                
                <div class="row-span-2 min-h-[300px]">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($homepageAbout->image_1): ?>
                    <img src="<?php echo e($homepageAbout->image_1_url); ?>" alt="" class="w-full h-full min-h-[300px] object-cover rounded-xl" />
                    <?php else: ?>
                    <div class="w-full h-full min-h-[300px] bg-gray-200 rounded-xl flex items-center justify-center text-gray-400">Main image</div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                <div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($homepageAbout->highlight_text || $homepageAbout->highlight_subtext): ?>
                    <div class="bg-gray-900 text-white rounded-xl px-6 py-8 text-center">
                        <span class="text-4xl font-bold block"><?php echo e($homepageAbout->highlight_text); ?></span>
                        <span class="text-4xl font-bold block"><?php echo e($homepageAbout->highlight_subtext); ?></span>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                <div class="self-end">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($homepageAbout->image_2): ?>
                    <img src="<?php echo e($homepageAbout->image_2_url); ?>" alt="" class="w-full h-40 sm:h-48 object-cover rounded-xl" />
                    <?php else: ?>
                    <div class="w-full h-40 sm:h-48 bg-gray-200 rounded-xl flex items-center justify-center text-gray-400">Image 2</div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?> -->


<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-end mb-16">
            <div>
                <p class="text-xs font-bold tracking-[0.2em] uppercase text-teal-600 mb-3">Why Travel With Us</p>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight">The Albania experience you won't find anywhere else</h2>
            </div>
            <p class="text-gray-500 leading-relaxed lg:text-right">
                We're not a marketplace — we're a local team that lives and breathes Albania. Every tour is designed, guided, and run by people who call this place home.
            </p>
        </div>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = [
                ['fa-solid fa-map-location-dot', 'teal',   'Local Guides Only',     'Every guide was born and raised here. They know the shortcuts, the stories, and the spots no app can find.'],
                ['fa-solid fa-people-group',     'violet', 'Small Groups',          'We cap group sizes so every trip feels personal — never rushed, never crowded, always memorable.'],
                ['fa-solid fa-circle-check',     'emerald','Transparent Pricing',   'No hidden fees, no surprises at checkout. The price you see is the exact price you pay.'],
                ['fa-solid fa-calendar-check',   'amber',  'Free Cancellation',     'Plans change. Most of our tours allow free cancellation up to 48 hours before departure.'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="group relative p-7 rounded-2xl border border-gray-100 bg-gray-50 hover:bg-white hover:shadow-lg hover:border-gray-200 transition-all duration-300">
                <div class="w-12 h-12 rounded-xl mb-6 flex items-center justify-center
                    <?php echo e($f[1] === 'teal'   ? 'bg-teal-50'   : ''); ?>

                    <?php echo e($f[1] === 'violet' ? 'bg-violet-50' : ''); ?>

                    <?php echo e($f[1] === 'emerald'? 'bg-emerald-50': ''); ?>

                    <?php echo e($f[1] === 'amber'  ? 'bg-amber-50'  : ''); ?>">
                    <i class="<?php echo e($f[0]); ?> text-lg
                        <?php echo e($f[1] === 'teal'   ? 'text-teal-600'   : ''); ?>

                        <?php echo e($f[1] === 'violet' ? 'text-violet-600' : ''); ?>

                        <?php echo e($f[1] === 'emerald'? 'text-emerald-600': ''); ?>

                        <?php echo e($f[1] === 'amber'  ? 'text-amber-600'  : ''); ?>"></i>
                </div>
                <h3 class="font-bold text-gray-900 mb-2"><?php echo e($f[2]); ?></h3>
                <p class="text-sm text-gray-500 leading-relaxed"><?php echo e($f[3]); ?></p>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        
        <div class="mt-14 rounded-2xl bg-[#0D9488] px-10 py-10 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
                <p class="text-white font-bold text-lg">Ready to start your Albanian adventure?</p>
                <p class="text-teal-100 text-sm mt-1">Browse 50+ handcrafted tours — day trips, multi-day, private & group.</p>
            </div>
            <a href="<?php echo e(route('tours.index')); ?>"
               class="flex-shrink-0 px-8 py-3.5 bg-white text-[#0D9488] text-sm font-bold rounded-full hover:bg-teal-50 transition shadow-md whitespace-nowrap">
                View All Tours
            </a>
        </div>

    </div>
</section>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($latestPosts->isNotEmpty()): ?>
<section class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-10">Latest from the Blog</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalef84dbe2113ee1aa06beffddb73fe07d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalef84dbe2113ee1aa06beffddb73fe07d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.blog-card','data' => ['post' => $post]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('blog-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalef84dbe2113ee1aa06beffddb73fe07d)): ?>
<?php $attributes = $__attributesOriginalef84dbe2113ee1aa06beffddb73fe07d; ?>
<?php unset($__attributesOriginalef84dbe2113ee1aa06beffddb73fe07d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalef84dbe2113ee1aa06beffddb73fe07d)): ?>
<?php $component = $__componentOriginalef84dbe2113ee1aa06beffddb73fe07d; ?>
<?php unset($__componentOriginalef84dbe2113ee1aa06beffddb73fe07d); ?>
<?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

<!-- <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <h2 class="text-3xl font-bold text-gray-900 mb-4">Ready to explore?</h2>
    <p class="text-gray-600 mb-6">Browse our tours and find your next adventure.</p>
    <a href="<?php echo e(route('tours.index')); ?>" class="inline-flex items-center px-6 py-3 bg-amber-600 text-white font-medium rounded-lg hover:bg-amber-700">View all tours</a>
</section> -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/kevinhitaj/Desktop/Projects/TOURS Second/resources/views/pages/home.blade.php ENDPATH**/ ?>