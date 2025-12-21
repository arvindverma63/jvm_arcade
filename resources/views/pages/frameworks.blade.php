<x-app-layout title="Frameworks & Tools - JVM Arcade" :right-sidebar="false">

    <div class="text-center max-w-2xl mx-auto mb-10">
        <h1 class="text-3xl font-bold text-white mb-3">Choose Your Weapon</h1>
        <p class="text-slate-400">
            The JVM ecosystem is vast. Whether you are building a high-performance 3D engine,
            a cozy 2D platformer, or a massive multiplayer server, there's a tool for you.
        </p>
    </div>

    <div
        class="relative bg-gradient-to-br from-red-900/50 via-brand-card to-brand-card rounded-2xl border border-red-500/30 p-8 mb-10 overflow-hidden group">
        <div class="absolute right-0 top-0 p-12 opacity-10 group-hover:opacity-20 transition-opacity">
            <i class="ph-fill ph-game-controller text-9xl text-red-500"></i>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
            <div
                class="w-24 h-24 rounded-2xl bg-white flex items-center justify-center shadow-[0_0_30px_rgba(239,68,68,0.4)]">
                <span class="text-red-600 font-bold text-2xl tracking-tighter">GDX</span>
            </div>
            <div class="flex-1 text-center md:text-left">
                <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                    <h2 class="text-2xl font-bold text-white">LibGDX</h2>
                    <span
                        class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-500 text-white uppercase tracking-wider">Top
                        Choice</span>
                </div>
                <p class="text-slate-300 mb-6 max-w-2xl">
                    The industry standard for Java game development. Write code once and deploy to Windows, Linux,
                    macOS, Android, iOS, and the Web (WebGL). It provides a unified API for 2D and 3D game development.
                </p>
                <div class="flex flex-wrap justify-center md:justify-start gap-3">
                    <button
                        class="px-5 py-2 rounded-lg bg-red-600 hover:bg-red-500 text-white font-bold transition-colors shadow-lg shadow-red-900/20">
                        View Documentation
                    </button>
                    <button
                        class="px-5 py-2 rounded-lg bg-brand-card border border-slate-600 text-slate-300 hover:text-white hover:border-slate-500 transition-colors">
                        <i class="ph-fill ph-star mr-1"></i> 22k Stars
                    </button>
                    <button
                        class="px-5 py-2 rounded-lg bg-brand-card border border-slate-600 text-slate-300 hover:text-white hover:border-slate-500 transition-colors">
                        Community Feed
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-2 mb-6 overflow-x-auto pb-2 scrollbar-hide">
        <button class="px-4 py-1.5 rounded-full bg-brand-accent text-brand-dark font-bold text-sm">All Tools</button>
        <button
            class="px-4 py-1.5 rounded-full bg-brand-card border border-slate-700 text-slate-400 hover:text-white text-sm transition-colors whitespace-nowrap">Game
            Engines</button>
        <button
            class="px-4 py-1.5 rounded-full bg-brand-card border border-slate-700 text-slate-400 hover:text-white text-sm transition-colors whitespace-nowrap">Low
            Level / Graphics</button>
        <button
            class="px-4 py-1.5 rounded-full bg-brand-card border border-slate-700 text-slate-400 hover:text-white text-sm transition-colors whitespace-nowrap">Server
            & Backend</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @php
            $tools = [
                [
                    'name' => 'LWJGL',
                    'desc' => 'Lightweight Java Game Library. Access OpenGL, Vulkan, OpenAL, and GLFW directly.',
                    'icon' => 'ph-brackets-curly',
                    'color' => 'text-green-400',
                    'bg' => 'bg-green-500/10',
                    'border' => 'hover:border-green-500/50',
                    'tags' => ['Low Level', 'OpenGL', 'Vulkan'],
                ],
                [
                    'name' => 'jMonkeyEngine',
                    'desc' =>
                        'A complete 3D game engine. Includes a visual editor (SDK), physics, and advanced rendering.',
                    'icon' => 'ph-cube',
                    'color' => 'text-yellow-400',
                    'bg' => 'bg-yellow-500/10',
                    'border' => 'hover:border-yellow-500/50',
                    'tags' => ['3D Engine', 'Physics', 'Editor'],
                ],
                [
                    'name' => 'FXGL',
                    'desc' =>
                        'JavaFX-based game engine. Perfect for 2D games, visual novels, and educational tools without low-level complexity.',
                    'icon' => 'ph-monitor-play',
                    'color' => 'text-blue-400',
                    'bg' => 'bg-blue-500/10',
                    'border' => 'hover:border-blue-500/50',
                    'tags' => ['2D', 'JavaFX', 'Easy'],
                ],
                [
                    'name' => 'Minecraft (Fabric)',
                    'desc' =>
                        'The modular modding toolchain. Create lightweight mods for the world\'s most popular Java game.',
                    'icon' => 'ph-cube-transparent',
                    'color' => 'text-emerald-400',
                    'bg' => 'bg-emerald-500/10',
                    'border' => 'hover:border-emerald-500/50',
                    'tags' => ['Modding', 'Mixin', 'Community'],
                ],
                [
                    'name' => 'Netty',
                    'desc' =>
                        'Asynchronous event-driven network application framework. The backbone of Minecraft servers and high-performance MMOs.',
                    'icon' => 'ph-arrows-left-right',
                    'color' => 'text-purple-400',
                    'bg' => 'bg-purple-500/10',
                    'border' => 'hover:border-purple-500/50',
                    'tags' => ['Networking', 'TCP/UDP', 'High Perf'],
                ],
                [
                    'name' => 'Korge',
                    'desc' =>
                        'Multiplatform game engine written in pure Kotlin. Targets JVM, JS, Android, iOS, and Desktop.',
                    'icon' => 'ph-device-mobile',
                    'color' => 'text-indigo-400',
                    'bg' => 'bg-indigo-500/10',
                    'border' => 'hover:border-indigo-500/50',
                    'tags' => ['Kotlin', 'Multiplatform', '2D'],
                ],
            ];
        @endphp

        @foreach ($tools as $tool)
            <div class="bg-brand-card rounded-xl border border-white/5 p-6 transition-all group {{ $tool['border'] }}">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-lg {{ $tool['bg'] }} flex items-center justify-center">
                        <i class="ph-fill {{ $tool['icon'] }} text-2xl {{ $tool['color'] }}"></i>
                    </div>
                    <button class="text-slate-500 hover:text-white transition-colors">
                        <i class="ph ph-arrow-square-out text-xl"></i>
                    </button>
                </div>

                <h3 class="text-lg font-bold text-white mb-2">{{ $tool['name'] }}</h3>
                <p class="text-sm text-slate-400 mb-4 h-16">{{ $tool['desc'] }}</p>

                <div class="flex flex-wrap gap-2">
                    @foreach ($tool['tags'] as $tag)
                        <span
                            class="text-[10px] font-mono bg-slate-800 text-slate-400 px-2 py-1 rounded border border-slate-700/50">
                            {{ $tag }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div
            class="bg-brand-card/50 rounded-xl border border-white/5 border-dashed p-6 flex flex-col items-center justify-center text-center hover:bg-brand-card transition-all cursor-pointer group">
            <div
                class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center mb-3 group-hover:bg-brand-accent group-hover:text-brand-dark transition-colors">
                <i class="ph ph-plus text-xl"></i>
            </div>
            <h3 class="text-sm font-bold text-white">Submit a Tool</h3>
            <p class="text-xs text-slate-500 mt-1">Did we miss a library?</p>
        </div>

    </div>

</x-app-layout>
