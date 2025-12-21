<x-app-layout title="Chat with {{ $user->name }}" :right-sidebar="false">

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .ql-toolbar.ql-snow {
            background-color: #0f172a;
            border-color: #334155 !important;
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .ql-container.ql-snow {
            background-color: #0f172a80;
            border-color: #334155 !important;
            border-radius: 0 0 0.5rem 0.5rem;
            color: #e2e8f0;
            font-size: 14px;
        }

        .ql-snow .ql-stroke {
            stroke: #94a3b8;
        }

        .ql-snow .ql-fill {
            fill: #94a3b8;
        }

        .ql-snow .ql-picker {
            color: #94a3b8;
        }

        /* Custom Scrollbar */
        #chat-scroller::-webkit-scrollbar {
            width: 6px;
        }

        #chat-scroller::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 3px;
        }
    </style>

    <div class="max-w-4xl mx-auto h-[calc(100vh-140px)] flex flex-col">

        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('messages.index') }}"
                    class="p-2 rounded-lg bg-slate-800 text-slate-400 hover:text-white hover:bg-slate-700 transition-colors">
                    <i class="ph-bold ph-arrow-left"></i>
                </a>
                <a href="{{ route('profile.show', $user->id) }}" class="flex items-center gap-3 group">
                    <img src="{{ $user->avatar ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $user->name }}"
                        class="w-10 h-10 rounded-full border border-slate-600 group-hover:border-brand-accent transition-colors">
                    <div>
                        <h2 class="text-lg font-bold text-white group-hover:text-brand-accent transition-colors">
                            {{ $user->name }}</h2>
                        <div class="flex items-center gap-1.5 text-xs text-slate-500">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span> Online
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div
            class="flex-1 bg-brand-card border border-white/5 rounded-t-xl overflow-hidden flex flex-col shadow-2xl relative">

            <div id="chat-scroller" class="flex-1 overflow-y-auto p-6 space-y-4 bg-[#0b0f19]">

                @foreach ($messages as $msg)
                    @php $isMe = $msg->sender_id === Auth::id(); @endphp

                    <div class="flex w-full {{ $isMe ? 'justify-end' : 'justify-start' }} group"
                        id="message-row-{{ $msg->id }}">
                        <div class="max-w-[75%] flex gap-3 {{ $isMe ? 'flex-row-reverse' : '' }}">

                            @if (!$isMe)
                                <img src="{{ $user->avatar ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $user->name }}"
                                    class="w-8 h-8 rounded-full border border-slate-700 self-end mb-1">
                            @endif

                            <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }} relative w-full">

                                <div id="msg-display-{{ $msg->id }}" class="group relative">
                                    <div
                                        class="px-4 py-2.5 rounded-2xl text-sm leading-relaxed shadow-sm prose prose-invert max-w-none
                                        {{ $isMe
                                            ? 'bg-brand-accent text-brand-dark rounded-tr-none'
                                            : 'bg-slate-800 text-slate-200 border border-slate-700 rounded-tl-none' }}">
                                        {!! $msg->body !!}
                                    </div>

                                    @if ($isMe)
                                        <div
                                            class="absolute top-0 -left-16 hidden group-hover:flex items-center gap-1 h-full px-2">
                                            <button onclick="editMessage({{ $msg->id }})"
                                                class="p-1.5 rounded-full bg-slate-800 text-slate-400 hover:text-white hover:bg-slate-700">
                                                <i class="ph-bold ph-pencil-simple"></i>
                                            </button>
                                            <form action="{{ route('messages.destroy', $msg->id) }}" method="POST"
                                                onsubmit="return confirm('Delete message?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 rounded-full bg-slate-800 text-slate-400 hover:text-red-500 hover:bg-slate-700">
                                                    <i class="ph-bold ph-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>

                                <div id="msg-edit-{{ $msg->id }}" class="hidden w-full min-w-[300px]">
                                    <form action="{{ route('messages.update', $msg->id) }}" method="POST"
                                        class="edit-form">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="body" class="ql-input">

                                        <div class="ql-editor-container bg-slate-900 rounded-lg">
                                            {!! $msg->body !!}
                                        </div>

                                        <div class="flex justify-end gap-2 mt-2">
                                            <button type="button" onclick="cancelEdit({{ $msg->id }})"
                                                class="text-xs text-slate-400 hover:text-white">Cancel</button>
                                            <button type="submit"
                                                class="px-3 py-1 rounded bg-brand-accent text-brand-dark text-xs font-bold">Save</button>
                                        </div>
                                    </form>
                                </div>

                                <span class="text-[10px] text-slate-600 mt-1 px-1 flex items-center gap-1">
                                    {{ $msg->created_at->format('g:i A') }}
                                    @if ($msg->updated_at != $msg->created_at)
                                        <span class="italic">(edited)</span>
                                    @endif
                                    @if ($isMe && $msg->read_at)
                                        <i class="ph-bold ph-check-double text-brand-accent"></i>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="p-4 bg-slate-900 border-t border-white/5">
                <form action="{{ route('messages.store', $user->id) }}" method="POST" id="main-chat-form">
                    @csrf
                    <input type="hidden" name="body" id="main-body">

                    <div id="main-editor" class="bg-slate-800 rounded-lg h-24 mb-2"></div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-6 py-2 rounded-lg bg-brand-accent text-brand-dark font-bold hover:bg-brand-glow transition-all flex items-center gap-2">
                            <i class="ph-fill ph-paper-plane-right"></i> Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        $(document).ready(function() {
            // 1. Initialize Main Editor
            var mainQuill = new Quill('#main-editor', {
                theme: 'snow',
                placeholder: 'Type a message...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'code-block'],
                        ['link', 'image'],
                        ['clean']
                    ]
                }
            });

            $('#main-chat-form').on('submit', function() {
                $('#main-body').val(mainQuill.root.innerHTML);
            });

            // Scroll to bottom
            const scroller = document.getElementById('chat-scroller');
            scroller.scrollTop = scroller.scrollHeight;
        });

        // 2. Toggle Edit Mode
        window.editMessage = function(id) {
            // Hide Display, Show Edit
            $(`#msg-display-${id}`).addClass('hidden');
            $(`#msg-edit-${id}`).removeClass('hidden');

            // Initialize Quill for this specific message if not already done
            var $container = $(`#msg-edit-${id} .ql-editor-container`);
            if (!$container.data('quill')) {
                var quill = new Quill($container[0], {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'code-block'],
                            ['link']
                        ]
                    }
                });
                $container.data('quill', quill);

                // Bind submit
                $(`#msg-edit-${id} .edit-form`).on('submit', function() {
                    $(this).find('.ql-input').val(quill.root.innerHTML);
                });
            }
        };

        window.cancelEdit = function(id) {
            $(`#msg-edit-${id}`).addClass('hidden');
            $(`#msg-display-${id}`).removeClass('hidden');
        };
    </script>

</x-app-layout>
