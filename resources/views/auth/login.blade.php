<x-guest-layout>
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-white mb-3">Welcome to JVM Arcade</h1>
        <p class="text-slate-400">Sign in to share snippets, track libraries, and join the discussion.</p>
    </div>

    <div class="space-y-4">

        <a href="{{ route('social.redirect', 'github') }}"
            class="group relative flex items-center justify-center gap-3 w-full bg-[#24292F] hover:bg-[#2b3036] text-white font-bold py-3.5 rounded-xl border border-white/10 transition-all hover:scale-[1.02] shadow-lg">

            <i class="ph-fill ph-github-logo text-2xl group-hover:text-white transition-colors"></i>
            <span>Continue with GitHub</span>

            <i
                class="ph-bold ph-arrow-right absolute right-5 opacity-0 group-hover:opacity-100 transition-all transform -translate-x-2 group-hover:translate-x-0"></i>
        </a>

        <a href="{{ route('social.redirect', 'google') }}"
            class="group relative flex items-center justify-center gap-3 w-full bg-white hover:bg-slate-50 text-slate-900 font-bold py-3.5 rounded-xl transition-all hover:scale-[1.02] shadow-lg">

            <i class="ph-fill ph-google-logo text-2xl text-red-500"></i>
            <span>Continue with Google</span>

            <i
                class="ph-bold ph-arrow-right absolute right-5 opacity-0 group-hover:opacity-100 transition-all transform -translate-x-2 group-hover:translate-x-0 text-slate-400"></i>
        </a>

    </div>

    <div class="mt-8 text-center">
        <p class="text-xs text-slate-500 max-w-xs mx-auto">
            By continuing, you agree to our
            <a href="#" class="text-slate-400 hover:text-brand-accent underline">Terms of Service</a>
            and
            <a href="#" class="text-slate-400 hover:text-brand-accent underline">Privacy Policy</a>.
        </p>
    </div>

    @if ($errors->any())
        <div class="mt-6 p-3 bg-red-500/10 border border-red-500/20 rounded-lg flex items-center gap-3">
            <i class="ph-fill ph-warning-circle text-red-500 text-xl"></i>
            <span class="text-xs text-red-400 font-medium">{{ $errors->first() }}</span>
        </div>
    @endif

</x-guest-layout>
