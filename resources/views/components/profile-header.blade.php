<div class="relative mb-6 group">

    {{-- 1. HEADER BANNER --}}
    {{-- We apply the custom banner as a background image if it exists. Otherwise, we show the default gradient. --}}
    <div class="h-48 w-full rounded-xl bg-cover bg-center bg-no-repeat relative overflow-hidden
                {{ $user->profile->banner ? '' : 'bg-gradient-to-r from-indigo-900 via-brand-dark to-brand-accent/20' }}"
        style="{{ $user->profile->banner ? 'background-image: url(' . asset($user->profile->banner) . ');' : '' }}">

        {{-- Pattern Overlay (Only shows if using default gradient to add texture) --}}
        @if (!$user->profile->banner)
            <div class="absolute inset-0 opacity-20"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            </div>
        @endif

        {{-- Dark Overlay for text readability if custom banner exists --}}
        @if ($user->profile->banner)
            <div class="absolute inset-0 bg-black/30"></div>
        @endif

        {{-- EDIT BANNER BUTTON (Only for Owner) --}}
        @if (Auth::id() === $user->id)
            <form action="{{ route('profile.image.update') }}" method="POST" enctype="multipart/form-data"
                class="absolute top-4 right-4 z-10">
                @csrf
                {{-- Hidden Input --}}
                <input type="file" name="banner" id="bannerInput" class="hidden" accept="image/*"
                    onchange="this.form.submit()">

                {{-- Visible Trigger --}}
                <button type="button" onclick="document.getElementById('bannerInput').click()"
                    class="bg-black/50 hover:bg-black/70 text-white text-xs px-3 py-1.5 rounded-full backdrop-blur-sm transition-all opacity-0 group-hover:opacity-100 flex items-center gap-2 cursor-pointer">
                    <i class="ph ph-camera"></i> Edit Banner
                </button>
            </form>
        @endif
    </div>

    {{-- 2. PROFILE INFO SECTION --}}
    <div class="px-6 relative">
        <div class="flex flex-col md:flex-row items-start md:items-end -mt-12 gap-6">

            {{-- AVATAR --}}
            <div class="relative group/avatar">
                {{-- The Image --}}
                <img src="{{ $user->avatar ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $user->name }}"
                    class="w-24 h-24 md:w-32 md:h-32 rounded-2xl border-4 border-brand-dark bg-brand-dark shadow-xl object-cover">

                {{-- EDIT AVATAR OVERLAY (Only for Owner) --}}
                @if (Auth::id() === $user->id)
                    <form action="{{ route('profile.image.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        {{-- Hidden Input --}}
                        <input type="file" name="avatar" id="avatarInput" class="hidden" accept="image/*"
                            onchange="this.form.submit()">

                        {{-- Visible Overlay Trigger --}}
                        <div onclick="document.getElementById('avatarInput').click()"
                            class="absolute inset-0 bg-black/50 rounded-2xl flex items-center justify-center opacity-0 group-hover/avatar:opacity-100 transition-opacity cursor-pointer">
                            <i class="ph-fill ph-camera text-white text-2xl"></i>
                        </div>
                    </form>
                @endif
            </div>

            {{-- USER DETAILS --}}
            <div class="flex-1 mb-2">
                <h1 class="text-2xl font-bold text-white">{{ $user->name }}</h1>

                <div class="flex flex-wrap items-center gap-3 text-sm text-slate-400 mt-1">
                    {{-- Title --}}
                    @if ($user->profile->title)
                        <span class="flex items-center gap-1">
                            <i class="ph-fill ph-code text-brand-accent"></i>
                            {{ $user->profile->title }}
                        </span>
                        <span class="text-slate-600">•</span>
                    @endif

                    {{-- Location (Optional, if you have this field) --}}
                    {{-- <span class="flex items-center gap-1"><i class="ph-fill ph-map-pin"></i> Grid World</span> --}}
                    {{-- <span class="text-slate-600">•</span> --}}

                    {{-- Joined Date --}}
                    <span class="text-slate-500">Joined {{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>

            {{-- Edit Profile Settings Button (Optional) --}}
            @if (Auth::id() === $user->id)
                <a href="{{ route('profile.update') }}"
                    class="mb-4 md:mb-2 px-4 py-2 text-sm font-medium text-slate-300 bg-slate-800 border border-slate-700 rounded-lg hover:text-white hover:bg-slate-700 transition-colors">
                    Edit Profile
                </a>
            @endif

        </div>
    </div>
</div>
