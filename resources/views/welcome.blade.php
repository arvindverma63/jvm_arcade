<x-app-layout title="Feed - JVM Arcade">

    <div class="flex gap-2 overflow-x-auto pb-2 md:pb-0 scrollbar-hide mb-4">
        <button
            class="whitespace-nowrap px-4 py-1.5 rounded-full bg-brand-accent text-brand-dark text-sm font-bold shadow-lg shadow-brand-accent/20">
            Feed
        </button>
        <button
            class="whitespace-nowrap px-4 py-1.5 rounded-full bg-brand-card border border-slate-700 text-slate-400 text-sm hover:border-slate-500 hover:text-white transition-colors">
            Showcase
        </button>
        <button
            class="whitespace-nowrap px-4 py-1.5 rounded-full bg-brand-card border border-slate-700 text-slate-400 text-sm hover:border-slate-500 hover:text-white transition-colors">
            Help Wanted
        </button>
    </div>

    @forelse($feed as $item)

        {{-- TYPE 1: CODE SNIPPET --}}
        @if (class_basename($item) === 'Snippet')
            <a href="{{ route('snippets.show', $item->id) }}" class="block mb-4">
                <div
                    class="bg-brand-card rounded-xl p-5 border border-white/5 hover:border-slate-600 transition-all cursor-pointer group relative overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-brand-accent"></div>

                    <div class="flex gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-2">
                                <span
                                    class="bg-brand-accent/10 text-brand-accent text-[10px] px-2 py-0.5 rounded border border-brand-accent/20 font-bold uppercase tracking-wide">
                                    {{ $item->language }}
                                </span>
                                <span class="text-slate-600 text-xs">•</span>
                                <div class="flex items-center gap-1.5">
                                    <img src="{{ $item->user->avatar ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $item->user->name }}"
                                        class="w-4 h-4 rounded-full">
                                    <span
                                        class="text-xs text-slate-400 group-hover:text-white transition-colors">{{ $item->user->name }}</span>
                                </div>
                                <span class="text-slate-600 text-xs ml-auto flex items-center gap-1">
                                    <i class="ph ph-clock"></i> {{ $item->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <h3
                                class="text-base font-semibold text-slate-100 mb-3 group-hover:text-brand-glow transition-colors">
                                {{ $item->title }}
                            </h3>

                            <div
                                class="bg-[#0d1117] rounded-lg border border-white/5 p-3 mb-3 font-mono text-xs text-slate-400 overflow-hidden relative h-24">
                                <div
                                    class="absolute top-0 right-0 p-2 bg-gradient-to-l from-[#0d1117] to-transparent w-16 h-full">
                                </div>
                                <pre class="opacity-80">{{ Str::limit($item->code, 300) }}</pre>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-1.5 text-xs text-brand-java">
                                    <i class="ph-fill ph-heart"></i> {{ $item->likes_count }} Likes
                                </div>
                                <div class="flex items-center gap-1.5 text-xs text-slate-500">
                                    <i class="ph ph-code"></i> Snippet
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            {{-- TYPE 2: NEWS POST --}}
        @elseif(isset($item->type) && $item->type === 'news')
            <a href="{{ route('post.show', $item->id) }}" class="block mb-4">
                <div
                    class="glass-effect rounded-xl p-5 border-l-4 border-brand-java relative overflow-hidden group hover:border-red-500 transition-all cursor-pointer">
                    <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
                        <i class="ph-fill ph-coffee-bean text-6xl text-brand-java"></i>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="flex-1 relative z-10">
                            <div class="flex items-center gap-2 mb-1">
                                <span
                                    class="bg-brand-java/10 text-brand-java text-[10px] font-bold px-2 py-0.5 rounded border border-brand-java/20 uppercase tracking-wide">News</span>
                                <span class="text-slate-500 text-xs flex items-center gap-1">
                                    <i class="ph ph-clock"></i> {{ $item->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <h2 class="text-lg font-bold text-white mb-2 group-hover:text-brand-glow transition-colors">
                                {{ $item->title }}
                            </h2>
                            <p class="text-slate-400 text-sm line-clamp-2">
                                {{ Str::limit(strip_tags($item->body), 150) }}
                            </p>
                        </div>
                    </div>
                </div>
            </a>

            {{-- TYPE 3: STANDARD DISCUSSION --}}
        @else
            <a href="{{ route('post.show', $item->id) }}" class="block mb-4">
                <div
                    class="bg-brand-card rounded-xl p-5 border border-white/5 hover:border-slate-600 transition-all cursor-pointer group">
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center gap-1 min-w-[32px]">
                            <i class="ph ph-caret-up text-lg text-slate-500"></i>
                            <span class="text-sm font-bold text-white">{{ $item->votes ?? 0 }}</span>
                            <i class="ph ph-caret-down text-lg text-slate-500"></i>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                @if ($item->tags)
                                    @foreach ($item->tags as $tag)
                                        <span
                                            class="{{ $tag->color ?? 'bg-slate-700/50 text-slate-400' }} text-[10px] px-2 py-0.5 rounded border border-white/5 uppercase font-bold tracking-wide">
                                            {{ $tag->name }}
                                        </span>
                                    @endforeach
                                @endif
                                <span class="text-slate-600 text-xs">•</span>
                                <span class="text-xs text-slate-400">Posted by {{ $item->user->name }}</span>
                            </div>

                            <h3
                                class="text-base font-semibold text-slate-100 mb-2 group-hover:text-brand-glow transition-colors">
                                {{ $item->title }}
                            </h3>
                            <p class="text-sm text-slate-400 mb-3 line-clamp-2">
                                {{ Str::limit(strip_tags($item->body), 120) }}
                            </p>

                            <div class="flex items-center gap-4 mt-4">
                                <div
                                    class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-slate-300 transition-colors">
                                    <i class="ph ph-chat-circle text-base"></i> {{ $item->comments_count ?? 0 }}
                                    Comments
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endif

    @empty
        <div class="text-center py-20">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-800 mb-4">
                <i class="ph-fill ph-coffee text-3xl text-slate-500"></i>
            </div>
            <h3 class="text-lg font-bold text-white">No activity yet</h3>
            <p class="text-slate-400 text-sm mb-6">The feed is quiet. Start the conversation!</p>
            <a href="{{ route('snippets.create') }}"
                class="px-6 py-2 rounded-full bg-brand-accent text-brand-dark font-bold hover:bg-brand-glow transition-colors">
                Create Snippet
            </a>
        </div>
    @endforelse

    <div class="mt-6">
        @if (isset($posts_paginator))
            {{ $posts_paginator->links() }}
        @endif
    </div>

</x-app-layout>
