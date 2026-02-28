<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-[#0D9488] border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-[#0b8277] focus:bg-[#0b8277] active:bg-[#0a7a6e] focus:outline-none focus:ring-2 focus:ring-[#0D9488] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
