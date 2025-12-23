<x-app-layout title="Latest Activity - JVM Arcade">

    {{-- HEADER & FILTERS --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-2">
            <div class="p-2 bg-brand-accent/10 rounded-lg text-brand-accent">
                <i class="ph-fill ph-clock-counter-clockwise text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-white leading-tight">Latest Activity</h1>
                <p class="text-xs text-slate-500">Real-time updates from the community</p>
            </div>
        </div>

        <div class="flex items-center bg-brand-card rounded-lg border border-white/5 p-1">
            <a href="{{ route('home') }}"
                class="px-3 py-1.5 rounded-md text-xs font-bold shadow-sm transition-colors {{ !request('filter') ? 'bg-slate-700 text-white' : 'text-slate-400 hover:text-white' }}">
                All
            </a>
            <a href="{{ route('home', ['filter' => 'posts']) }}"
                class="px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request('filter') == 'posts' ? 'bg-slate-700 text-white' : 'text-slate-400 hover:text-white' }}">
                Posts
            </a>
            <a href="{{ route('home', ['filter' => 'questions']) }}"
                class="px-3 py-1.5 rounded-md text-xs font-medium transition-colors {{ request('filter') == 'questions' ? 'bg-slate-700 text-white' : 'text-slate-400 hover:text-white' }}">
                Questions
            </a>
            <div class="w-px h-4 bg-slate-700 mx-1"></div>
            <button class="px-2 py-1.5 text-slate-500 hover:text-brand-accent transition-colors">
                <i class="ph ph-sliders text-sm"></i>
            </button>
        </div>
    </div>

    {{-- TIMELINE FEED --}}
    <div class="space-y-4 relative">

        {{-- The Vertical Line --}}
        <div class="absolute left-6 top-4 bottom-4 w-px bg-slate-800 -z-10 hidden sm:block"></div>

        @forelse($activities as $activity)
            <div
                class="bg-brand-card rounded-xl border border-white/5 p-0 overflow-hidden hover:border-brand-accent/30 transition-all group">

                {{-- Decorative Gradient for "Help/Question" posts --}}
                @if ($activity->tags->contains(fn($t) => in_array(strtolower($t->name), ['help', 'question', 'issue'])))
                    <div
                        class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-bl from-brand-success/10 to-transparent pointer-events-none">
                    </div>
                @endif

                <div class="p-5 flex gap-4">
                    {{-- Avatar --}}
                    <div class="flex-shrink-0 z-10">
                        <a href="{{ route('profile.show', $activity->user->id) }}">
                            <img src="{{ $activity->user->avatar ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $activity->user->name }}"
                                class="w-10 h-10 rounded-full ring-4 ring-brand-card hover:ring-brand-accent transition-all">
                        </a>
                    </div>

                    <div class="flex-1 min-w-0">
                        {{-- Header Row --}}
                        <div class="flex items-baseline justify-between mb-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <a href="{{ route('profile.show', $activity->user->id) }}"
                                    class="font-bold text-slate-200 text-sm hover:text-brand-accent cursor-pointer">
                                    {{ $activity->user->name }}
                                </a>
                                <span class="text-slate-600 text-xs">•</span>
                                <span
                                    class="text-slate-500 text-xs">{{ $activity->created_at->diffForHumans(null, true) }}</span>
                            </div>

                            {{-- Dynamic Badge (Show first tag if exists) --}}
                            @if ($activity->tags->isNotEmpty())
                                @php $mainTag = $activity->tags->first(); @endphp
                                <span
                                    class="text-[10px] font-bold px-2 py-0.5 rounded border uppercase
                                    {{ strtolower($mainTag->name) == 'help' || strtolower($mainTag->name) == 'question'
                                        ? 'bg-brand-success/10 text-brand-success border-brand-success/20'
                                        : 'bg-purple-500/10 text-purple-400 border-purple-500/20' }}">
                                    {{ $mainTag->name }}
                                </span>
                            @endif
                        </div>

                        {{-- Title & Body --}}
                        <a href="{{ route('snippets.show', $activity->id) }}" class="block group/title">
                            <h3
                                class="text-base font-semibold text-slate-100 mb-2 group-hover/title:text-brand-accent transition-colors">
                                {{ $activity->title }}
                            </h3>
                            <p class="text-sm text-slate-400 mb-3 line-clamp-2">
                                {!! strip_tags($activity->description) !!}
                            </p>
                        </a>

                        {{-- Code Preview (Replaces Image) --}}
                        <div
                            class="relative w-full bg-[#0d1117] rounded-lg overflow-hidden border border-white/5 mb-3 group/code">
                            <div class="p-3 text-[10px] font-mono text-slate-400 overflow-x-auto">
                                <pre>{{ Str::limit($activity->code, 200) }}</pre>
                            </div>
                            {{-- Gradient Fade at bottom --}}
                            <div
                                class="absolute bottom-0 left-0 w-full h-8 bg-gradient-to-t from-[#0d1117] to-transparent">
                            </div>

                            {{-- Language Label --}}
                            <div
                                class="absolute top-2 right-2 px-1.5 py-0.5 rounded bg-slate-800 text-[10px] text-slate-400 border border-white/5 uppercase">
                                {{ $activity->language }}
                            </div>
                        </div>

                        {{-- Tags Row --}}
                        @if ($activity->tags->count() > 1)
                            <div class="flex gap-2 mb-3 flex-wrap">
                                @foreach ($activity->tags->slice(1, 3) as $tag)
                                    <span
                                        class="text-[10px] font-mono bg-slate-800 text-slate-400 px-2 py-1 rounded">#{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        {{-- Footer Actions --}}
                        <div class="flex items-center gap-4 border-t border-white/5 pt-3 mt-1">
                            {{-- Likes (AJAX Ready) --}}
                            <button
                                class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-red-400 transition-colors group/btn"
                                onclick="/* Add your like JS here */">
                                <i
                                    class="ph-fill ph-heart text-base group-hover/btn:scale-110 transition-transform {{ $activity->likes_count > 0 ? 'text-red-400' : '' }}"></i>
                                {{ $activity->likes_count }}
                            </button>

                            {{-- Comments Link --}}
                            <a href="{{ route('snippets.show', $activity->id) }}#comments"
                                class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-blue-400 transition-colors">
                                <i class="ph ph-chat-circle text-base"></i>
                                {{ $activity->comments_count }} Comments
                            </a>

                            {{-- Share Button --}}
                            <button
                                class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-white transition-colors ml-auto">
                                <i class="ph ph-share-network text-base"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            {{-- Empty State --}}
            <div class="text-center py-12 bg-brand-card rounded-xl border border-white/5 border-dashed">
                <div
                    class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-500">
                    <i class="ph-fill ph-coffee text-3xl"></i>
                </div>
                <h3 class="text-white font-bold mb-1">It's quiet... too quiet.</h3>
                <p class="text-slate-400 text-sm mb-4">Be the first to post something amazing!</p>
                <a href="{{ route('snippets.create') }}"
                    class="px-4 py-2 bg-brand-accent text-brand-dark font-bold text-sm rounded-lg hover:bg-brand-glow transition-colors">
                    Create Post
                </a>
            </div>
        @endforelse

    </div>

    {{-- Pagination --}}
    @if ($activities->hasPages())
        <div class="mt-8">
            {{ $activities->withQueryString()->links() }}
        </div>
    @endif

</x-app-layout>
