<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('components.head')
</head>

<body
    class="bg-brand-dark text-slate-300 font-sans antialiased selection:bg-brand-accent selection:text-brand-dark flex items-center justify-center min-h-screen relative overflow-hidden">

    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-brand-accent/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-red-600/10 rounded-full blur-[120px]"></div>
    </div>

    <div class="absolute top-8 left-8">
        <a href="/" class="flex items-center gap-2 group">
            <div
                class="w-10 h-10 rounded-lg bg-gradient-to-br from-orange-600 to-red-600 flex items-center justify-center text-white font-bold shadow-lg shadow-orange-500/20 group-hover:scale-110 transition-transform">
                <i class="ph-fill ph-coffee"></i>
            </div>
            <span class="text-white font-bold text-xl tracking-tight">JVM<span
                    class="text-brand-glow">Arcade</span></span>
        </a>
    </div>

    <div
        class="w-full max-w-md bg-brand-card/80 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl p-8 relative z-10 mx-4">
        {{ $slot }}
    </div>

</body>

</html>
