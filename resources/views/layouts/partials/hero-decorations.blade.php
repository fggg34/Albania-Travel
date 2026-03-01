{{--
    Floating tour-icon decorations for page hero sections.
    Include inside any `relative overflow-hidden` hero section.
--}}

@once
<style>
    @keyframes hd-float  { 0%,100%{ transform: translateY(0px) rotate(0deg); }   50%{ transform: translateY(-20px) rotate(6deg); } }
    @keyframes hd-floatB { 0%,100%{ transform: translateY(0px) rotate(0deg); }   50%{ transform: translateY(18px) rotate(-5deg); } }
    @keyframes hd-drift  { 0%,100%{ transform: translate(0,0); } 33%{ transform: translate(14px,-12px); } 66%{ transform: translate(-10px,14px); } }
    @keyframes hd-driftB { 0%,100%{ transform: translate(0,0); } 33%{ transform: translate(-12px,10px); } 66%{ transform: translate(10px,-16px); } }
    @keyframes hd-spin   { from{ transform: rotate(0deg); } to{ transform: rotate(360deg); } }

    .hd-icon { position: absolute; pointer-events: none; user-select: none; will-change: transform; color: #f59e0b; line-height: 1; }
</style>
@endonce

<div class="absolute inset-0 pointer-events-none select-none overflow-hidden" aria-hidden="true">

    {{-- Compass — top-right, large --}}
    <div class="hd-icon" style="top:8%;right:5%;font-size:6rem;opacity:.15;animation:hd-float 14s ease-in-out infinite;">
        <i class="fa-solid fa-compass"></i>
    </div>

    {{-- Mountain-sun — bottom-left --}}
    <div class="hd-icon" style="bottom:12%;left:3%;font-size:5rem;opacity:.12;animation:hd-floatB 17s ease-in-out infinite;animation-delay:1.5s;">
        <i class="fa-solid fa-mountain-sun"></i>
    </div>

    {{-- Plane — upper-left, tilted, drifts --}}
    <div class="hd-icon" style="top:14%;left:20%;font-size:2.6rem;opacity:.13;transform:rotate(-30deg);animation:hd-drift 22s ease-in-out infinite;animation-delay:3s;">
        <i class="fa-solid fa-plane"></i>
    </div>

    {{-- Location pin — mid-right --}}
    <div class="hd-icon" style="top:52%;right:11%;font-size:2.4rem;opacity:.14;animation:hd-float 12s ease-in-out infinite;animation-delay:5s;">
        <i class="fa-solid fa-location-dot"></i>
    </div>

    {{-- Camera — bottom-right --}}
    <div class="hd-icon" style="bottom:14%;right:7%;font-size:3.2rem;opacity:.12;animation:hd-floatB 13s ease-in-out infinite;animation-delay:2s;">
        <i class="fa-solid fa-camera"></i>
    </div>

    {{-- Sun — top-left, slow spin --}}
    <div class="hd-icon" style="top:6%;left:5%;font-size:3.8rem;opacity:.10;animation:hd-spin 55s linear infinite;">
        <i class="fa-solid fa-sun"></i>
    </div>

    {{-- Binoculars — mid-left --}}
    <div class="hd-icon" style="top:44%;left:8%;font-size:2rem;opacity:.12;animation:hd-driftB 19s ease-in-out infinite;animation-delay:4s;">
        <i class="fa-solid fa-binoculars"></i>
    </div>

    {{-- Anchor — bottom-center --}}
    <div class="hd-icon" style="bottom:8%;right:28%;font-size:1.8rem;opacity:.11;animation:hd-float 16s ease-in-out infinite;animation-delay:6s;">
        <i class="fa-solid fa-anchor"></i>
    </div>

    {{-- Map — top-center --}}
    <div class="hd-icon" style="top:18%;left:42%;font-size:1.6rem;opacity:.11;animation:hd-driftB 25s ease-in-out infinite;animation-delay:9s;">
        <i class="fa-solid fa-map"></i>
    </div>

    {{-- Leaf — mid bottom-left --}}
    <div class="hd-icon" style="bottom:28%;left:16%;font-size:1.5rem;opacity:.12;animation:hd-floatB 20s ease-in-out infinite;animation-delay:2.5s;">
        <i class="fa-solid fa-leaf"></i>
    </div>

    {{-- Subtle warm glow blobs --}}
    <div style="position:absolute;top:-8%;right:-6%;width:420px;height:420px;border-radius:50%;background:radial-gradient(circle,rgba(245,158,11,.05),transparent 70%);pointer-events:none;"></div>
    <div style="position:absolute;bottom:-10%;left:-4%;width:320px;height:320px;border-radius:50%;background:radial-gradient(circle,rgba(245,158,11,.04),transparent 70%);pointer-events:none;"></div>

</div>
