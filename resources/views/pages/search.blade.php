<x-app-layout title="Search - JVM Arcade" :right-sidebar="false">

    <div class="max-w-4xl mx-auto mb-10 text-center">
        <h1 class="text-3xl font-bold text-white mb-6">Search JVM Arcade</h1>

        <form action="{{ route('search') }}" method="GET" class="relative max-w-2xl mx-auto">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="ph-bold ph-magnifying-glass text-slate-400 text-xl"></i>
            </div>
            <input type="text" name="q" value="{{ $query }}" autofocus
                placeholder="Search snippets, members, tags..."
                class="w-full bg-slate-800/50 border border-slate-700 text-white rounded-xl py-4 pl-12 pr-4 text-lg focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all shadow-xl">
            <button type="submit"
                class="absolute right-2 top-2 bottom-2 bg-brand-accent text-brand-dark font-bold px-4 rounded-lg hover:bg-brand-glow transition-colors">
                Search
            </button>
        </form>

        @if ($query)
            <p class="text-slate-400 mt-4 text-sm">
                Showing results for <span class="text-white font-bold">"{{ $query }}"</span>
            </p>
        @endif
    </div>

    @if (!$query)
        <div class="text-center py-20 opacity-50">
            <i class="ph-duotone ph-magnifying-glass text-6xl text-slate-600 mb-4"></i>
            <p class="text-slate-500">Type something above to start searching.</p>
        </div>
    @else
        <div class="max-w-6xl mx-auto space-y-12">

            @if ($users->isNotEmpty())
                <div>
                    <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <i class="ph-fill ph-users text-brand-accent"></i> Members Found
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach ($users as $user)
                            <a href="{{ route('profile.show', $user->id) }}"
                                class="flex items-center gap-4 bg-brand-card border border-white/5 p-4 rounded-xl hover:border-brand-accent/50 transition-colors group">
                                <img src="{{ $user->avatar ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $user->name }}"
                                    class="w-12 h-12 rounded-full border border-slate-700 group-hover:border-brand-accent transition-colors">
                                <div class="min-w-0">
                                    <h3
                                        class="font-bold text-white truncate group-hover:text-brand-accent transition-colors">
                                        {{ $user->name }}</h3>
                                    <p class="text-xs text-slate-500">{{ $user->followers_count }} Followers</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <div>
                <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <i class="ph-fill ph-code text-brand-accent"></i> Snippets Found
                </h2>

                @if ($snippets->isEmpty())
                    <div class="bg-brand-card border border-white/5 rounded-xl p-8 text-center">
                        <p class="text-slate-500">No snippets found matching "{{ $query }}".</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($snippets as $snippet)
                            <a href="{{ route('snippets.show', $snippet->id) }}" class="block group">
                                <div
                                    class="bg-brand-card border border-white/5 rounded-xl p-5 hover:border-brand-accent/30 transition-all hover:bg-slate-800/50">
                                    <div class="flex items-start gap-4">
                                        <div
                                            class="shrink-0 w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center border border-slate-700 text-xs font-bold text-slate-300">
                                            {{ substr($snippet->language, 0, 2) }}
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-1">
                                                <h3
                                                    class="text-lg font-bold text-white truncate group-hover:text-brand-accent transition-colors">
                                                    {{ $snippet->title }}
                                                </h3>
                                                <span
                                                    class="bg-slate-800 text-slate-400 text-[10px] px-1.5 py-0.5 rounded border border-slate-700">{{ $snippet->language }}</span>
                                            </div>

                                            <p class="text-slate-400 text-sm font-mono truncate opacity-70 mb-2">
                                                {{ Str::limit($snippet->code, 120) }}
                                            </p>

                                            <div class="flex items-center gap-4 text-xs text-slate-500">
                                                <span class="flex items-center gap-1">
                                                    <img src="{{ $snippet->user->avatar ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $snippet->user->name }}"
                                                        class="w-4 h-4 rounded-full">
                                                    {{ $snippet->user->name }}
                                                </span>
                                                <span class="flex items-center gap-1"><i class="ph-fill ph-heart"></i>
                                                    {{ $snippet->likes_count }}</span>
                                                <span class="flex items-center gap-1"><i
                                                        class="ph-fill ph-chat-circle"></i>
                                                    {{ $snippet->comments_count }}</span>
                                                <span>{{ $snippet->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $snippets->appends(['q' => $query])->links() }}
                    </div>
                @endif
            </div>

        </div>
    @endif

</x-app-layout>
