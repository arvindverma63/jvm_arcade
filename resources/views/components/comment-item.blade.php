@props(['comment', 'depth' => 0])

<div class="flex gap-4 border-t border-white/5 pt-6 {{ $depth > 0 ? 'ml-12 border-none pt-4' : '' }}"
    id="comment-{{ $comment->id }}">

    <img src="{{ $comment->user->avatar ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $comment->user->name }}"
        class="w-8 h-8 rounded-full shrink-0">

    <div class="flex-1 min-w-0">
        <div class="flex items-center justify-between mb-1">
            <h4 class="text-sm font-bold text-white">{{ $comment->user->name }}</h4>
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-500">{{ $comment->created_at->diffForHumans() }}</span>

                {{-- 7-DAY EDIT/DELETE CHECK --}}
                @if (Auth::id() === $comment->user_id && $comment->created_at->gt(now()->subDays(7)))
                    <div class="flex items-center gap-1 ml-2">
                        <button onclick="toggleEdit({{ $comment->id }})"
                            class="text-xs text-slate-500 hover:text-brand-accent transition-colors" title="Edit">
                            <i class="ph-bold ph-pencil-simple"></i>
                        </button>

                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this comment?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-slate-500 hover:text-red-500 transition-colors"
                                title="Delete">
                                <i class="ph-bold ph-trash"></i>
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>

        <div id="comment-body-{{ $comment->id }}" class="prose prose-invert prose-sm max-w-none text-slate-300 mb-2">
            {!! $comment->body !!}
        </div>

        <div id="edit-box-{{ $comment->id }}" class="hidden mt-2 mb-4">
            <form action="{{ route('comments.update', $comment->id) }}" method="POST" class="comment-submission-form">
                @csrf
                @method('PUT')
                <input type="hidden" name="body" class="quill-hidden-input">

                <div class="quill-wrapper bg-[#0d1117] rounded-lg border border-slate-700">
                    <div class="quill-editor" style="height: 100px;">{!! $comment->body !!}</div>
                </div>

                <div class="flex justify-end gap-2 mt-2">
                    <button type="button" onclick="toggleEdit({{ $comment->id }})"
                        class="px-3 py-1.5 rounded text-xs font-bold text-slate-400 hover:text-white">Cancel</button>
                    <button type="submit"
                        class="px-4 py-1.5 rounded bg-brand-accent text-brand-dark text-xs font-bold hover:bg-brand-glow">Update</button>
                </div>
            </form>
        </div>

        <div class="flex items-center gap-4">
            <button onclick="toggleReply({{ $comment->id }})"
                class="text-xs font-bold text-brand-accent hover:text-white transition-colors flex items-center gap-1">
                <i class="ph-bold ph-arrow-bend-down-right"></i> Reply
            </button>
        </div>

        <div id="reply-box-{{ $comment->id }}"
            class="hidden mt-4 bg-slate-800/50 p-4 rounded-lg border border-white/5">
            <form action="{{ route('comments.store') }}" method="POST" class="comment-submission-form">
                @csrf
                <input type="hidden" name="commentable_id" value="{{ $comment->id }}">
                <input type="hidden" name="commentable_type" value="App\Models\Comment">
                <input type="hidden" name="body" class="quill-hidden-input">

                <div class="quill-wrapper bg-[#0d1117]">
                    <div class="quill-editor" style="height: 100px;"></div>
                </div>

                <div class="flex justify-end mt-2">
                    <button type="submit"
                        class="px-4 py-1.5 rounded bg-brand-accent text-brand-dark text-xs font-bold hover:bg-brand-glow">Reply</button>
                </div>
            </form>
        </div>

        @foreach ($comment->comments as $reply)
            @include('components.comment-item', ['comment' => $reply, 'depth' => $depth + 1])
        @endforeach
    </div>
</div>
