<x-filament-panels::page>
    <div class="space-y-6">

        {{-- Page header --}}
        <div class="flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                QR codes are auto-generated for every public page on your website.
                Download individual PNGs or grab everything in one ZIP.
            </p>
            <a href="{{ $downloadAll }}"
               class="inline-flex items-center gap-2 rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <svg style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
                Download all as ZIP
            </a>
        </div>

        {{-- Groups --}}
        @foreach ($groups as $group => $items)
            <div class="rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">

                {{-- Group header --}}
                <div class="flex items-center justify-between border-b border-gray-200 px-5 py-3 dark:border-gray-700">
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ $group }}</h2>
                    <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                        {{ count($items) }} {{ count($items) === 1 ? 'page' : 'pages' }}
                    </span>
                </div>

                <div class="grid gap-4 p-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($items as $item)
                        <div class="flex items-center gap-3 rounded-lg border border-gray-100 bg-gray-50/60 p-3 text-left transition hover:border-primary-300 hover:bg-white hover:shadow-md dark:border-gray-700 dark:bg-gray-900/40 dark:hover:border-primary-500">

                            {{-- QR preview (SVG pre-generated in PHP) --}}
                            <div class="overflow-hidden rounded-md bg-white p-1 shadow-sm" style="width:72px;height:72px;flex-shrink:0;">
                                <div style="width:64px;height:64px;display:flex;align-items:center;justify-content:center;">
                                    {!! preg_replace('/width="\d+" height="\d+"/', 'width="64" height="64"', $item['svg']) !!}
                                </div>
                            </div>

                            <div class="min-w-0 flex-1 space-y-1">
                                {{-- Label --}}
                                <p class="truncate text-xs font-semibold text-gray-900 dark:text-gray-100"
                                   title="{{ $item['label'] }}">
                                    {{ $item['label'] }}
                                </p>

                                {{-- URL --}}
                                <p class="truncate text-[11px] text-gray-500 dark:text-gray-400" title="{{ $item['url'] }}">
                                    {{ $item['url'] }}
                                </p>

                                {{-- Actions --}}
                                <div class="flex flex-wrap items-center gap-1.5 pt-0.5">
                                    <a href="{{ $item['url'] }}" target="_blank"
                                       class="inline-flex items-center gap-1 rounded border border-gray-200 bg-white px-1.5 py-0.5 text-[11px] font-medium text-gray-600 hover:bg-gray-100 hover:text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-800"
                                       title="Open page">
                                        <svg style="width: 14px; height: 14px;" xmlns="http://www.w3.org/2000/svg" class="inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                        Visit
                                    </a>
                                    <a href="{{ $item['downloadUrl'] }}"
                                       class="inline-flex items-center gap-1 rounded bg-primary-50 px-1.5 py-0.5 text-[11px] font-semibold text-primary-700 hover:bg-primary-100 dark:bg-primary-900/30 dark:text-primary-400 dark:hover:bg-primary-900/50"
                                       title="Download PNG">
                                        <svg style="width: 14px; height: 14px;" xmlns="http://www.w3.org/2000/svg" class="inline" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                        PNG
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

    </div>
</x-filament-panels::page>
