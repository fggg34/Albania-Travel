<x-app-layout>

    {{-- Hero bar --}}
    <div class="bg-[#111111] py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto flex items-center gap-5">
            <div class="w-14 h-14 rounded-2xl bg-[#CC1021]/20 border border-[#CC1021]/30 flex items-center justify-center flex-shrink-0">
                <i class="fa-solid fa-user text-[#CC1021] text-xl"></i>
            </div>
            <div>
                <p class="text-xs font-semibold text-brand-400 uppercase tracking-widest mb-1">Account Settings</p>
                <h1 class="text-xl sm:text-2xl font-bold text-white">Your Profile</h1>
                <p class="text-gray-400 text-sm mt-0.5">Manage your personal information and account security.</p>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 min-h-screen py-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto space-y-6">

            {{-- Profile Information --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#CC1021]/10 flex items-center justify-center">
                        <i class="fa-solid fa-id-card text-[#CC1021] text-sm"></i>
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900 text-sm">Profile Information</h2>
                        <p class="text-xs text-gray-400">Update your name and email address</p>
                    </div>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-[#CC1021]/10 flex items-center justify-center">
                        <i class="fa-solid fa-lock text-[#CC1021] text-sm"></i>
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900 text-sm">Update Password</h2>
                        <p class="text-xs text-gray-400">Use a long, random password to stay secure</p>
                    </div>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="bg-white rounded-2xl border border-red-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-red-50 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center">
                        <i class="fa-solid fa-triangle-exclamation text-red-500 text-sm"></i>
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900 text-sm">Danger Zone</h2>
                        <p class="text-xs text-gray-400">Permanently delete your account and all data</p>
                    </div>
                </div>
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
