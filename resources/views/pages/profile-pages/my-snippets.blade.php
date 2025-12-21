<x-app-layout title="My Snippets - JVM Arcade" :right-sidebar="false">

    @include('components.profile-header')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <div class="lg:col-span-1 space-y-6">
            @include('components.profile-sidebar')
        </div>

        <div class="lg:col-span-3">

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white">My Snippets</h2>
                <a href="{{ route('snippets.create') }}"
                    class="px-4 py-2 rounded-lg bg-brand-accent text-brand-dark text-sm font-bold hover:bg-brand-glow transition-colors">
                    + New Snippet
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                @forelse($snippets as $snippet)
                    <div
                        class="bg-brand-card rounded-xl border border-white/5 overflow-hidden hover:border-slate-500 transition-all group">
                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <div
                                    class="text-[10px] font-bold px-2 py-0.5 rounded border uppercase
                                    {{ strtolower($snippet->language) == 'java'
                                        ? 'bg-orange-500/10 text-orange-400 border-orange-500/20'
                                        : (strtolower($snippet->language) == 'kotlin'
                                            ? 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20'
                                            : 'bg-slate-700 text-slate-300 border-slate-600') }}">
                                    {{ $snippet->language }}
                                </div>

                                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('snippets.edit', $snippet->id) }}"
                                        class="text-slate-500 hover:text-white transition-colors">
                                        <i class="ph-bold ph-pencil-simple"></i>
                                    </a>

                                    <form action="{{ route('snippets.destroy', $snippet->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this snippet permanently?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-slate-500 hover:text-red-500 transition-colors">
                                            <i class="ph-bold ph-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <a href="{{ route('snippets.show', $snippet->id) }}" class="block">
                                <h3
                                    class="text-base font-bold text-white mb-2 truncate hover:text-brand-accent transition-colors">
                                    {{ $snippet->title }}
                                </h3>

                                <div class="text-xs text-slate-400 line-clamp-2 mb-3 h-8">
                                    {!! strip_tags($snippet->description) !!}
                                </div>

                                <div
                                    class="bg-[#0d1117] p-2 rounded border border-white/5 font-mono text-[10px] text-slate-400 mb-3 opacity-80 h-16 overflow-hidden relative">
                                    {{ Str::limit($snippet->code, 150) }}
                                    <div
                                        class="absolute bottom-0 left-0 w-full h-6 bg-gradient-to-t from-[#0d1117] to-transparent">
                                    </div>
                                </div>
                            </a>

                            <div
                                class="flex items-center justify-between text-xs text-slate-500 border-t border-white/5 pt-3 mt-1">
                                <div class="flex gap-3">
                                    <span class="flex items-center gap-1 hover:text-red-400 transition-colors">
                                        <i class="ph-fill ph-heart"></i> {{ $snippet->likes_count ?? 0 }}
                                    </span>
                                    <span class="flex items-center gap-1 hover:text-blue-400 transition-colors">
                                        <i class="ph-fill ph-chat-circle"></i> {{ $snippet->comments_count ?? 0 }}
                                    </span>
                                </div>
                                <span>{{ $snippet->created_at->diffForHumans(null, true) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center border border-dashed border-slate-700 rounded-xl">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-800 mb-3 text-slate-500">
                            <i class="ph-fill ph-code-block text-xl"></i>
                        </div>
                        <h3 class="text-white font-bold mb-1">No snippets yet</h3>
                        <p class="text-slate-400 text-xs mb-4">Start building your library today.</p>
                        <a href="{{ route('snippets.create') }}"
                            class="text-brand-accent text-sm font-bold hover:underline">Create your first snippet</a>
                    </div>
                @endforelse

            </div>

            <div class="mt-6">
                {{ $snippets->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
