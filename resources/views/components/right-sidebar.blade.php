<aside class="hidden lg:block lg:col-span-3 space-y-6 sticky top-24 self-start">

    @php
        $topUsers = \App\Models\User::withCount('snippets')->orderByDesc('snippets_count')->take(5)->get();

        $trendingSnippets = \App\Models\Snippet::withCount('likes')->orderByDesc('likes_count')->take(4)->get();

        $totalDevs = \App\Models\User::count();
    @endphp

    {{-- 1. COMMUNITY STATS CARD --}}
    <div class="bg-brand-card rounded-xl border border-white/5 p-4">
        <div class="flex items-center gap-3 mb-4">
            <div
                class="w-10 h-10 rounded-lg bg-gradient-to-br from-brand-accent to-orange-600 flex items-center justify-center text-brand-dark font-bold">
                <i class="ph-fill ph-code text-xl"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-white">JVM Arcade</h3>
                <p class="text-xs text-slate-400">Write Once, Play Anywhere.</p>
            </div>
        </div>

        <div class="flex justify-between text-center mb-4 border-b border-slate-700/50 pb-4">
            <div>
                {{-- Dynamic User Count --}}
                <div class="text-lg font-bold text-white">
                    {{ $totalDevs > 1000 ? round($totalDevs / 1000, 1) . 'k' : $totalDevs }}
                </div>
                <div class="text-[10px] text-slate-500 uppercase font-semibold">Devs</div>
            </div>
            <div>
                {{-- Placeholder for Online (Requires complex session/cache logic, kept static/random for now) --}}
                <div class="text-lg font-bold text-brand-success flex items-center gap-1">
                    <span class="animate-pulse w-2 h-2 rounded-full bg-brand-success"></span>
                    {{ rand(12, 45) }}
                </div>
                <div class="text-[10px] text-slate-500 uppercase font-semibold">Online</div>
            </div>
        </div>

        <button
            class="w-full bg-slate-700 hover:bg-slate-600 text-white text-sm font-medium py-2 rounded-lg transition-colors mb-2 flex items-center justify-center gap-2">
            <i class="ph-fill ph-discord-logo"></i> Join Discord
        </button>
    </div>

    {{-- 2. TOP CONTRIBUTORS --}}
    <div class="bg-brand-card rounded-xl border border-white/5 p-4">
        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Top Contributors</h3>
        <div class="space-y-4">
            @foreach ($topUsers as $topUser)
                <a href="{{ route('profile.show', $topUser->id) }}" class="flex items-center gap-3 group">
                    <div class="relative">
                        <img src="{{ $topUser->avatar ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $topUser->name }}"
                            class="w-8 h-8 rounded-full border border-slate-700 group-hover:border-brand-accent transition-colors object-cover">
                        {{-- Gold Crown for #1 --}}
                        @if ($loop->first)
                            <div class="absolute -top-1.5 -right-1 text-yellow-400 text-xs">
                                <i class="ph-fill ph-crown"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div
                            class="text-sm font-medium text-slate-200 truncate group-hover:text-brand-accent transition-colors">
                            {{ $topUser->name }}
                        </div>
                        <div class="text-[10px] text-slate-500 truncate">
                            {{ $topUser->snippets_count }} Snippets
                            @if ($topUser->profile && $topUser->profile->title)
                                • {{ Str::limit($topUser->profile->title, 15) }}
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    {{-- 3. TRENDING SNIPPETS (New Section) --}}
    <div class="bg-brand-card rounded-xl border border-white/5 p-4">
        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
            <i class="ph-fill ph-trend-up text-brand-accent"></i> Trending
        </h3>
        <div class="space-y-4">
            @foreach ($trendingSnippets as $trend)
                <div class="group">
                    <a href="{{ route('snippets.show', $trend->id) }}"
                        class="block text-sm font-bold text-slate-300 hover:text-white transition-colors mb-1 truncate">
                        {{ $trend->title }}
                    </a>
                    <div class="flex items-center justify-between text-[10px] text-slate-500">
                        <span>{{ $trend->language }}</span>
                        <span class="flex items-center gap-1">
                            <i class="ph-fill ph-heart text-red-400"></i> {{ $trend->likes_count }}
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</aside>
