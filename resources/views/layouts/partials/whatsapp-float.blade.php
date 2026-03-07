@php
    $whatsappNumber = \App\Models\Setting::get('whatsapp_number', '') ?: \App\Models\Setting::get('contact_phone', '');
    $whatsappNumber = preg_replace('/[^0-9]/', '', $whatsappNumber);
@endphp
@if($whatsappNumber)
<a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp"
   class="whatsapp-float-btn fixed bottom-6 right-6 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-lg transition hover:scale-110 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-[#25D366] focus:ring-offset-2">
    <i class="fa-brands fa-whatsapp text-2xl"></i>
</a>
@endif
