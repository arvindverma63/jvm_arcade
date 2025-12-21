<x-app-layout title="{{ $snippet->title }} - JVM Arcade" :right-sidebar="false">

    @include('pages.snippet-details.style')
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-6">

        <div class="lg:col-span-3 space-y-6">

            <a href="{{ route('profile.snippets') }}"
                class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-white transition-colors">
                <i class="ph-bold ph-arrow-left"></i> Back to Snippets
            </a>

            <div class="bg-brand-card border border-white/5 rounded-xl overflow-hidden shadow-xl">

                <div class="p-6 border-b border-white/5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span
                                    class="bg-brand-accent/10 text-brand-accent text-xs px-2 py-0.5 rounded border border-brand-accent/20 font-bold uppercase tracking-wide">
                                    {{ $snippet->language }}
                                </span>
                                <span class="text-slate-500 text-xs flex items-center gap-1">
                                    <i class="ph ph-clock"></i> {{ $snippet->created_at->format('M d, Y') }}
                                </span>
                            </div>
                            <h1 class="text-2xl font-bold text-white mb-2">{{ $snippet->title }}</h1>
                        </div>

                        <div class="flex items-center gap-3 text-right">
                            <div class="hidden sm:block">
                                <div class="text-sm font-bold text-white">{{ $snippet->user->name }}</div>
                                <div class="text-xs text-slate-500">Author</div>
                            </div>
                            <img src="{{ $snippet->user->avatar ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $snippet->user->name }}"
                                class="w-10 h-10 rounded-full border border-slate-700">
                        </div>
                    </div>
                </div>

                <div class="relative group">
                    <div class="flex items-center justify-between bg-[#0d1117] border-b border-slate-800 px-4 py-2">
                        <div class="flex items-center gap-2">
                            <div class="flex gap-1.5 opacity-50">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                            <span class="text-xs text-slate-500 font-mono ml-3 opacity-70">
                                Snippet.{{ strtolower($snippet->language) == 'kotlin' ? 'kt' : 'java' }}
                            </span>
                        </div>
                        <button onclick="copyToClipboard()"
                            class="text-xs text-slate-500 hover:text-white flex items-center gap-1 transition-colors">
                            <i class="ph-bold ph-copy"></i> <span id="copy-text">Copy</span>
                        </button>
                    </div>

                    <div
                        class="bg-[#0d1117] relative flex overflow-hidden max-h-[600px] overflow-y-auto custom-scrollbar">
                        <div class="hidden sm:block py-4 pl-2 pr-3 text-right select-none text-slate-600 font-mono text-sm border-r border-slate-800 bg-slate-800/10 min-w-[3rem]"
                            id="line-numbers">
                        </div>

                        <div class="flex-1 overflow-x-auto p-4">
                            <pre class="mono-font text-slate-300 whitespace-pre" id="code-display"></pre>
                        </div>
                    </div>
                </div>

                @if ($snippet->description)
                    <div class="p-6 bg-slate-900/30 border-t border-white/5">
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-2">Description</h3>
                        <div class="prose prose-invert prose-sm max-w-none text-slate-300">
                            {!! $snippet->description !!}
                        </div>
                    </div>
                @endif
            </div>

            <div class="bg-brand-card border border-white/5 rounded-xl p-6">
                <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
                    <i class="ph-fill ph-chat-circle-text"></i> Discussion
                </h3>

                <div class="flex gap-4 mb-8">
                    <img src="{{ Auth::user()->avatar ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . Auth::user()->name }}"
                        class="w-8 h-8 rounded-full hidden sm:block">

                    <div class="flex-1 min-w-0">
                        <form action="{{ route('comments.store') }}" method="POST" class="comment-submission-form">
                            @csrf
                            <input type="hidden" name="commentable_id" value="{{ $snippet->id }}">
                            <input type="hidden" name="commentable_type" value="App\Models\Snippet">
                            <input type="hidden" name="body" class="quill-hidden-input">

                            <div class="quill-wrapper">
                                <div class="quill-editor" style="height: 120px;"></div>
                            </div>

                            <div class="flex justify-end mt-3">
                                <button type="submit"
                                    class="px-6 py-2 rounded-lg bg-brand-accent text-brand-dark text-sm font-bold hover:bg-brand-glow transition-colors shadow-lg shadow-brand-accent/20">
                                    Post Comment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="space-y-6">
                    @forelse($snippet->comments as $comment)
                        @include('components.comment-item', ['comment' => $comment, 'depth' => 0])
                    @empty
                        <div class="text-center py-8 border-t border-white/5">
                            <p class="text-slate-500 text-sm">No comments yet. Be the first to discuss this snippet!</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <div class="lg:col-span-1 space-y-6">

            <div class="bg-brand-card border border-white/5 rounded-xl p-4 space-y-3">
                <button onclick="toggleLike({{ $snippet->id }}, 'App\\Models\\Snippet', this)"
                    class="w-full py-2 rounded-lg font-bold transition-all flex items-center justify-center gap-2
                    {{ $snippet->isLikedBy(Auth::user()) ? 'bg-red-500 text-white shadow-lg shadow-red-900/20' : 'bg-brand-accent text-brand-dark hover:bg-brand-glow' }}">
                    <i class="{{ $snippet->isLikedBy(Auth::user()) ? 'ph-fill' : 'ph-bold' }} ph-heart text-lg"></i>
                    <span class="like-text">{{ $snippet->isLikedBy(Auth::user()) ? 'Liked' : 'Like Snippet' }}</span>
                </button>

                <button
                    class="w-full py-2 rounded-lg bg-slate-800 text-slate-300 font-bold hover:text-white hover:bg-slate-700 transition-colors flex items-center justify-center gap-2">
                    <i class="ph-bold ph-bookmark-simple"></i> Save
                </button>
            </div>

            <div class="bg-brand-card border border-white/5 rounded-xl p-4">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Stats</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-2xl font-bold text-white like-count-display">{{ $snippet->likes_count }}</div>
                        <div class="text-xs text-slate-500">Likes</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-white">{{ $snippet->comments->count() }}</div>
                        <div class="text-xs text-slate-500">Comments</div>
                    </div>
                </div>
            </div>

            <div class="bg-brand-card border border-white/5 rounded-xl p-4">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Tags</h3>
                <div class="flex flex-wrap gap-2">
                    @forelse($snippet->tags as $tag)
                        <span
                            class="text-xs px-2 py-1 rounded bg-slate-800 text-slate-400 border border-slate-700">#{{ $tag->name }}</span>
                    @empty
                        <span class="text-xs text-slate-600">No tags</span>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <textarea id="raw-code" class="hidden">{{ $snippet->code }}</textarea>

    @include('pages.snippet-details.script')

</x-app-layout>
