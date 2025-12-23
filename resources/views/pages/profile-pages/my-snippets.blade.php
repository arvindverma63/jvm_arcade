<x-app-layout title="My Snippets - JVM Arcade" :right-sidebar="false">

    @php
        $user = Auth()->user();
    @endphp
    @include('components.profile-header')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        {{-- Sidebar --}}
        <div class="lg:col-span-1 space-y-6">
            @include('components.profile-sidebar')
        </div>

        {{-- Main Content --}}
        <div class="lg:col-span-3">

            {{-- Page Header --}}
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white">My Snippets</h2>
                <a href="{{ route('snippets.create') }}"
                    class="px-4 py-2 rounded-lg bg-brand-accent text-brand-dark text-sm font-bold hover:bg-brand-glow transition-colors shadow-lg shadow-brand-accent/10">
                    + New Snippet
                </a>
            </div>

            {{-- Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                @forelse($snippets as $snippet)
                    <div
                        class="bg-brand-card rounded-xl border border-white/5 overflow-hidden hover:border-slate-500 hover:shadow-xl transition-all group flex flex-col h-full">
                        <div class="p-4 flex flex-col flex-1">

                            {{-- Top Row: Language & Actions --}}
                            <div class="flex justify-between items-start mb-3">
                                {{-- Language Badge with Dynamic Colors --}}
                                @php
                                    $lang = strtolower($snippet->language);
                                    $badgeClass = match ($lang) {
                                        'java' => 'bg-orange-500/10 text-orange-400 border-orange-500/20',
                                        'kotlin' => 'bg-indigo-500/10 text-indigo-400 border-indigo-500/20',
                                        'scala' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                        'groovy' => 'bg-green-500/10 text-green-400 border-green-500/20',
                                        default => 'bg-slate-700 text-slate-300 border-slate-600',
                                    };
                                @endphp
                                <div
                                    class="text-[10px] font-bold px-2 py-0.5 rounded border uppercase tracking-wider {{ $badgeClass }}">
                                    {{ $snippet->language }}
                                </div>

                                {{-- Edit/Delete Actions (Visible on Hover) --}}
                                <div class="flex gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('snippets.edit', $snippet->id) }}"
                                        class="text-slate-500 hover:text-white transition-colors" title="Edit">
                                        <i class="ph-bold ph-pencil-simple text-lg"></i>
                                    </a>

                                    <form action="{{ route('snippets.destroy', $snippet->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this snippet? This cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-slate-500 hover:text-red-500 transition-colors" title="Delete">
                                            <i class="ph-bold ph-trash text-lg"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Main Link --}}
                            <a href="{{ route('snippets.show', $snippet->id) }}" class="block flex-1 group/link">
                                <h3
                                    class="text-base font-bold text-white mb-2 truncate group-hover/link:text-brand-accent transition-colors">
                                    {{ $snippet->title }}
                                </h3>

                                <div class="text-xs text-slate-400 line-clamp-2 mb-3 h-8 leading-relaxed">
                                    {{ Str::limit(strip_tags($snippet->description), 80) }}
                                </div>

                                {{-- Code Preview --}}
                                <div
                                    class="bg-[#0d1117] p-2 rounded border border-white/5 font-mono text-[10px] text-slate-400 mb-3 opacity-80 h-16 overflow-hidden relative">
                                    <code class="block">{{ Str::limit($snippet->code, 150) }}</code>
                                    <div
                                        class="absolute bottom-0 left-0 w-full h-8 bg-gradient-to-t from-[#0d1117] to-transparent">
                                    </div>
                                </div>
                            </a>

                            {{-- Footer Stats --}}
                            <div
                                class="flex items-center justify-between text-xs text-slate-500 border-t border-white/5 pt-3 mt-auto">
                                <div class="flex gap-4">
                                    <span
                                        class="flex items-center gap-1.5 hover:text-red-400 transition-colors cursor-default"
                                        title="Likes">
                                        <i class="ph-fill ph-heart"></i> {{ $snippet->likes_count }}
                                    </span>
                                    <span
                                        class="flex items-center gap-1.5 hover:text-blue-400 transition-colors cursor-default"
                                        title="Comments">
                                        <i class="ph-fill ph-chat-circle"></i> {{ $snippet->comments_count }}
                                    </span>
                                </div>
                                <span class="text-[10px]">{{ $snippet->created_at->diffForHumans(null, true) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Empty State --}}
                    <div
                        class="col-span-full py-16 text-center border border-dashed border-slate-700 rounded-xl bg-slate-800/20">
                        <div
                            class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-slate-800 mb-4 text-slate-500">
                            <i class="ph-fill ph-code-block text-2xl"></i>
                        </div>
                        <h3 class="text-white font-bold text-lg mb-2">No snippets yet</h3>
                        <p class="text-slate-400 text-sm mb-6 max-w-xs mx-auto">Your library is empty. Share your first
                            piece of code with the community!</p>
                        <a href="{{ route('snippets.create') }}"
                            class="inline-flex items-center gap-2 text-brand-dark bg-brand-accent px-5 py-2.5 rounded-lg text-sm font-bold hover:bg-brand-glow transition-all">
                            <i class="ph-bold ph-plus"></i> Create Snippet
                        </a>
                    </div>
                @endforelse

            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $snippets->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
