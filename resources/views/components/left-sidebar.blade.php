<aside class="hidden md:block md:col-span-3 lg:col-span-2 space-y-6 sticky top-24 self-start">
    <div class="space-y-1">

        {{-- Home / Hot Topics Link --}}
        @php
            $isHome = request()->routeIs('home');
            $activeClass = 'bg-brand-accent/10 text-brand-glow font-medium';
            $inactiveClass = 'text-slate-400 hover:bg-brand-hover hover:text-slate-100 transition-colors';
        @endphp

        <a href="{{ route('home') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg {{ $isHome ? $activeClass : $inactiveClass }}">
            <i class="{{ $isHome ? 'ph-fill' : 'ph' }} ph-fire text-lg"></i>
            Hot Topics
        </a>

        {{-- Latest Link --}}
        @php
            $isLatest = request()->routeIs('latest');
        @endphp

        <a href="{{ route('latest') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg {{ $isLatest ? $activeClass : $inactiveClass }}">
            <i class="{{ $isLatest ? 'ph-fill' : 'ph' }} ph-clock text-lg"></i>
            Latest
        </a>

        {{-- Tags Link --}}
        @php
            $isTags = request()->routeIs('tags');
        @endphp

        <a href="{{ route('tags') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg {{ $isTags ? $activeClass : $inactiveClass }}">
            <i class="{{ $isTags ? 'ph-fill' : 'ph' }} ph-hash text-lg"></i>
            Tags
        </a>

        {{-- Members Link (NEW) --}}
        @php
            $isMembers = request()->routeIs('members.index');
        @endphp

        <a href="{{ route('members.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-lg {{ $isMembers ? $activeClass : $inactiveClass }}">
            <i class="{{ $isMembers ? 'ph-fill' : 'ph' }} ph-users text-lg"></i>
            Members
        </a>

    </div>

    <div class="border-t border-slate-700/50 my-4"></div>

    {{-- Frameworks List --}}
    <div>
        <h3 class="px-3 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Frameworks</h3>
        <div class="space-y-1">
            @php
                $frameworks = [
                    [
                        'name' => 'LibGDX',
                        'color' => 'bg-red-500',
                        'shadow' => 'shadow-[0_0_8px_rgba(239,68,68,0.8)]',
                        'count' => '12k',
                    ],
                    [
                        'name' => 'LWJGL',
                        'color' => 'bg-green-500',
                        'shadow' => 'shadow-[0_0_8px_rgba(34,197,94,0.8)]',
                        'count' => '5.4k',
                    ],
                    [
                        'name' => 'jMonkey',
                        'color' => 'bg-yellow-500',
                        'shadow' => 'shadow-[0_0_8px_rgba(234,179,8,0.8)]',
                        'count' => '2.1k',
                    ],
                    [
                        'name' => 'Minecraft',
                        'color' => 'bg-emerald-600',
                        'shadow' => 'shadow-[0_0_8px_rgba(5,150,105,0.8)]',
                        'count' => '45k',
                    ],
                ];
            @endphp
            @foreach ($frameworks as $fw)
                <a href="#"
                    class="flex items-center justify-between px-3 py-2 rounded-lg text-slate-400 hover:bg-brand-hover hover:text-white group transition-colors">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full {{ $fw['color'] }} {{ $fw['shadow'] }}"></span>
                        {{ $fw['name'] }}
                    </div>
                    <span
                        class="text-xs bg-slate-800 px-1.5 rounded text-slate-500 group-hover:text-slate-300">{{ $fw['count'] }}</span>
                </a>
            @endforeach
            <a href="{{ route('frameworks') }}"
                class="flex items-center justify-between px-3 py-2 rounded-lg {{ request()->routeIs('frameworks') ? 'bg-brand-accent/10 text-white' : 'text-slate-400 hover:bg-brand-hover hover:text-white' }} group transition-colors mb-2">
                <div class="flex items-center gap-2">
                    <i class="ph-fill ph-squares-four"></i>
                    <span class="font-bold text-xs uppercase tracking-wider">Browse All</span>
                </div>
            </a>
        </div>
    </div>
</aside>
