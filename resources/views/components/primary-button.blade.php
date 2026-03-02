<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-5 py-2.5 bg-[#CC1021] border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-[#a50d18] focus:bg-[#a50d18] active:bg-[#7f1020] focus:outline-none focus:ring-2 focus:ring-[#CC1021] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
