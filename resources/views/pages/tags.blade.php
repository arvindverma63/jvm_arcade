<x-app-layout title="Explore Tags - JVM Arcade">

    <div class="mb-8 text-center sm:text-left">
        <h1 class="text-2xl font-bold text-white mb-2">Explore Topics</h1>
        <p class="text-slate-400 text-sm mb-6">Find libraries, frameworks, and discussions that interest you.</p>

        <div class="relative max-w-xl">
            <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-lg"></i>
            <input type="text" placeholder="Find a tag (e.g. #kotlin, #opengl)..."
                class="w-full bg-brand-card border border-white/10 rounded-xl py-3 pl-12 pr-4 text-slate-200 placeholder-slate-500 focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all shadow-lg">
        </div>
    </div>

    <div class="mb-8">
        <h2 class="flex items-center gap-2 text-sm font-bold text-slate-300 uppercase tracking-wider mb-4">
            <i class="ph-fill ph-trend-up text-brand-accent"></i> Trending Now
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div
                class="group relative bg-gradient-to-br from-red-900/40 to-brand-card border border-red-500/20 rounded-xl p-5 overflow-hidden hover:border-red-500/50 transition-all cursor-pointer">
                <div class="absolute -right-4 -bottom-4 text-red-500/10 group-hover:text-red-500/20 transition-colors">
                    <i class="ph-fill ph-coffee text-9xl"></i>
                </div>
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-2">
                        <span
                            class="text-xl font-bold text-white group-hover:text-red-400 transition-colors">#Java21</span>
                        <span class="bg-red-500/20 text-red-300 text-xs font-bold px-2 py-1 rounded">+12%</span>
                    </div>
                    <p class="text-slate-400 text-sm mb-4">Discussions about virtual threads and ZGC.</p>
                    <div class="text-xs text-slate-500 font-mono">1.2k Posts this week</div>
                </div>
            </div>

            <div
                class="group relative bg-gradient-to-br from-blue-900/40 to-brand-card border border-blue-500/20 rounded-xl p-5 overflow-hidden hover:border-blue-500/50 transition-all cursor-pointer">
                <div
                    class="absolute -right-4 -bottom-4 text-blue-500/10 group-hover:text-blue-500/20 transition-colors">
                    <i class="ph-fill ph-cube text-9xl"></i>
                </div>
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-2">
                        <span
                            class="text-xl font-bold text-white group-hover:text-blue-400 transition-colors">#LibGDX</span>
                        <span class="bg-blue-500/20 text-blue-300 text-xs font-bold px-2 py-1 rounded">+8%</span>
                    </div>
                    <p class="text-slate-400 text-sm mb-4">Cross-platform game development framework.</p>
                    <div class="text-xs text-slate-500 font-mono">840 Posts this week</div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <h2 class="flex items-center gap-2 text-sm font-bold text-slate-300 uppercase tracking-wider mb-4">
            <i class="ph-fill ph-hash text-brand-accent"></i> All Categories
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @php
                $tags = [
                    [
                        'name' => 'Spring Boot',
                        'posts' => '15k',
                        'color' => 'text-green-400',
                        'bg' => 'bg-green-500/10',
                        'border' => 'border-green-500/20',
                    ],
                    [
                        'name' => 'OpenGL',
                        'posts' => '3.2k',
                        'color' => 'text-blue-400',
                        'bg' => 'bg-blue-500/10',
                        'border' => 'border-blue-500/20',
                    ],
                    [
                        'name' => 'Multiplayer',
                        'posts' => '900',
                        'color' => 'text-purple-400',
                        'bg' => 'bg-purple-500/10',
                        'border' => 'border-purple-500/20',
                    ],
                    [
                        'name' => 'Physics',
                        'posts' => '450',
                        'color' => 'text-orange-400',
                        'bg' => 'bg-orange-500/10',
                        'border' => 'border-orange-500/20',
                    ],
                    [
                        'name' => 'Kotlin',
                        'posts' => '8.1k',
                        'color' => 'text-indigo-400',
                        'bg' => 'bg-indigo-500/10',
                        'border' => 'border-indigo-500/20',
                    ],
                    [
                        'name' => 'UI/UX',
                        'posts' => '1.2k',
                        'color' => 'text-pink-400',
                        'bg' => 'bg-pink-500/10',
                        'border' => 'border-pink-500/20',
                    ],
                    [
                        'name' => 'Android',
                        'posts' => '22k',
                        'color' => 'text-emerald-400',
                        'bg' => 'bg-emerald-500/10',
                        'border' => 'border-emerald-500/20',
                    ],
                    [
                        'name' => 'DevLog',
                        'posts' => '5.6k',
                        'color' => 'text-slate-300',
                        'bg' => 'bg-slate-700/50',
                        'border' => 'border-slate-600',
                    ],
                    [
                        'name' => 'Beginner',
                        'posts' => '12k',
                        'color' => 'text-yellow-400',
                        'bg' => 'bg-yellow-500/10',
                        'border' => 'border-yellow-500/20',
                    ],
                ];
            @endphp

            @foreach ($tags as $tag)
                <div
                    class="bg-brand-card rounded-lg border border-white/5 p-4 flex items-center justify-between hover:border-slate-500 transition-all group cursor-pointer">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-lg {{ $tag['bg'] }} {{ $tag['border'] }} border flex items-center justify-center">
                            <span class="text-lg font-bold {{ $tag['color'] }}">#</span>
                        </div>
                        <div>
                            <h3 class="text-slate-200 font-bold text-sm group-hover:text-white transition-colors">
                                {{ $tag['name'] }}</h3>
                            <p class="text-xs text-slate-500">{{ $tag['posts'] }} posts</p>
                        </div>
                    </div>
                    <button class="text-slate-600 hover:text-brand-accent transition-colors">
                        <i class="ph-fill ph-star text-lg"></i>
                    </button>
                </div>
            @endforeach
        </div>

        <div class="mt-6 text-center">
            <button
                class="text-sm text-slate-500 hover:text-white transition-colors flex items-center justify-center gap-2 w-full">
                <span>Show all 240 tags</span>
                <i class="ph ph-caret-down"></i>
            </button>
        </div>
    </div>

</x-app-layout>
