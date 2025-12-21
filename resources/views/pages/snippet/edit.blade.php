<x-app-layout title="Edit Snippet - {{ $snippet->title }}" :right-sidebar="false">

    {{-- Reusing the styles from the create page --}}
    @include('pages.snippet.style')

    @push('styles')
        <style>
            .tag-pill {
                display: inline-flex;
                align-items: center;
                background: rgba(251, 191, 36, 0.1);
                border: 1px solid rgba(251, 191, 36, 0.2);
                color: #fbbf24;
                border-radius: 9999px;
                padding: 0.125rem 0.625rem;
                font-size: 0.75rem;
                font-weight: 600;
                margin-right: 0.25rem;
                margin-bottom: 0.25rem;
            }

            .tag-pill i {
                margin-left: 0.375rem;
                cursor: pointer;
                opacity: 0.7;
            }

            .tag-pill i:hover {
                opacity: 1;
                color: #fff;
            }

            .tags-input-container {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                min-height: 46px;
                cursor: text;
            }

            .tags-input-container input {
                flex: 1;
                min-width: 120px;
                border: none;
                background: transparent;
                outline: none;
                color: #e2e8f0;
                font-size: 0.875rem;
                padding: 0;
                margin: 0;
            }

            .tags-input-container input:focus {
                ring: 0;
                outline: none;
                box-shadow: none;
            }
        </style>
    @endpush

    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                    <i class="ph-fill ph-pencil-simple text-brand-accent"></i>
                    Edit Snippet
                </h1>
                <p class="text-slate-400 text-sm mt-1">Updating: <span class="text-white">{{ $snippet->title }}</span></p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('snippets.show', $snippet->id) }}"
                    class="text-sm text-slate-500 hover:text-white transition-colors py-2">Cancel</a>
            </div>
        </div>

        <div class="bg-brand-card border border-white/5 rounded-xl overflow-hidden shadow-xl">
            <form action="{{ route('snippets.update', $snippet->id) }}" method="POST" class="p-6 space-y-6"
                id="edit-snippet-form">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Title</label>
                        <input type="text" name="title" required value="{{ old('title', $snippet->title) }}"
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-slate-200 focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all">
                        @error('title')
                            <span class="text-red-400 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Language</label>
                        <div class="relative">
                            <select name="language" id="language-select"
                                class="w-full appearance-none bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-slate-200 focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all cursor-pointer">
                                @foreach (['Java', 'Kotlin', 'Scala', 'Groovy', 'JSON'] as $lang)
                                    <option value="{{ $lang }}"
                                        {{ $snippet->language == $lang ? 'selected' : '' }}>{{ $lang }}</option>
                                @endforeach
                            </select>
                            <i
                                class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none"></i>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Code</label>
                    </div>

                    <div class="rounded-lg border border-slate-700 overflow-hidden bg-[#0d1117] flex flex-col">
                        <div
                            class="flex items-center gap-2 bg-slate-800/50 border-b border-slate-700 px-4 py-2 select-none z-10">
                            <div class="flex gap-1.5">
                                <div class="w-3 h-3 rounded-full bg-red-500/50"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500/50"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500/50"></div>
                            </div>
                            <span class="text-xs text-slate-500 font-mono ml-2"
                                id="filename-display">Snippet.{{ strtolower($snippet->language) == 'kotlin' ? 'kt' : 'java' }}</span>
                        </div>

                        <div class="flex relative bg-[#0d1117]">
                            <div id="line-numbers"
                                class="mono-font hidden sm:flex flex-col items-end gap-0 pt-3 pr-2 pl-3 bg-slate-800/20 text-slate-600 select-none border-r border-slate-800 w-10 shrink-0 text-right h-[320px] overflow-hidden">
                                1
                            </div>
                            <div class="editor-wrapper">
                                <pre id="syntax-highlight" class="editor-layer syntax-layer mono-font"><code id="code-output"></code></pre>
                                <textarea name="code" id="code-input" required spellcheck="false" autocomplete="off" data-gramm="false"
                                    class="editor-layer input-layer mono-font">{{ old('code', $snippet->code) }}</textarea>
                            </div>
                        </div>
                    </div>
                    @error('code')
                        <span class="text-red-400 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Description</label>
                    <input type="hidden" name="description" id="quill-content-input"
                        value="{{ $snippet->description }}">
                    <div id="quill-wrapper">
                        <div id="quill-editor-container">{!! $snippet->description !!}</div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tags</label>

                    <div id="tags-visual-container"
                        class="tags-input-container w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-1.5 transition-all focus-within:border-brand-accent focus-within:ring-1 focus-within:ring-brand-accent">
                        <input type="text" id="tag-typing-input" placeholder="Add tags (separate with comma)..."
                            autocomplete="off">
                    </div>

                    <input type="hidden" name="tags" id="hidden-tags-input">
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-700/50">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg text-sm font-bold bg-brand-accent text-brand-dark hover:bg-brand-glow shadow-lg shadow-brand-accent/20 transition-all flex items-center gap-2">
                        <i class="ph-bold ph-check"></i>
                        Update Snippet
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        $(document).ready(function() {
            // --- 1. QUILL EDITOR ---
            var toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                [{
                    'header': [1, 2, 3, false]
                }],
                ['link', 'image', 'video'],
                ['clean']
            ];

            var quill = new Quill('#quill-editor-container', {
                modules: {
                    toolbar: toolbarOptions
                },
                theme: 'snow',
                placeholder: 'Explain how this code works...'
            });

            // On Submit, update hidden field
            $('#edit-snippet-form').on('submit', function() {
                var html = quill.root.innerHTML;
                $('#quill-content-input').val(html);
            });

            // --- 2. TAGS LOGIC (Pre-fill) ---
            const $tagInput = $('#tag-typing-input');
            const $tagContainer = $('#tags-visual-container');
            const $hiddenTags = $('#hidden-tags-input');

            // PRE-FILL TAGS FROM DATABASE
            let tags = {!! json_encode($snippet->tags->pluck('name')) !!};

            // Initial Render
            renderTags();
            updateHiddenInput();

            $tagContainer.on('click', function() {
                $tagInput.focus();
            });

            $tagInput.on('keydown', function(e) {
                const val = $(this).val().trim();
                if (e.key === ',' || e.key === 'Enter') {
                    e.preventDefault();
                    if (val && !tags.includes(val)) {
                        addTag(val);
                    }
                    $(this).val('');
                } else if (e.key === 'Backspace' && val === '') {
                    if (tags.length > 0) removeTag(tags.length - 1);
                }
            });

            function addTag(text) {
                text = text.replace(/,/g, '').trim();
                if (!text) return;
                tags.push(text);
                renderTags();
                updateHiddenInput();
            }

            // Global scope for onclick
            window.removeTag = function(index) {
                tags.splice(index, 1);
                renderTags();
                updateHiddenInput();
            }

            function renderTags() {
                $tagContainer.find('.tag-pill').remove();
                tags.forEach((tag, index) => {
                    const pill = `
                        <div class="tag-pill">
                            <span>#${tag}</span>
                            <i class="ph-bold ph-x" onclick="removeTag(${index})"></i>
                        </div>
                    `;
                    $tagInput.before(pill);
                });
            }

            function updateHiddenInput() {
                $hiddenTags.val(tags.join(','));
            }

            // --- 3. CODE EDITOR SYNTAX HIGHLIGHTING ---
            const $input = $('#code-input');
            const $output = $('#code-output');
            const $lineNumbers = $('#line-numbers');
            const keywords =
                /\b(public|private|protected|class|static|void|int|float|double|boolean|String|new|return|if|else|for|while|import|package|fun|val|var)\b/g;

            function highlight(text) {
                let html = text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
                const placeholders = {};
                let pCount = 0;

                function store(str) {
                    const key = `__TOKEN_${pCount++}__`;
                    placeholders[key] = str;
                    return key;
                }
                html = html.replace(/(".*?"|'.*?')/g, match => store(`<span class="token-string">${match}</span>`));
                html = html.replace(/(\/\/.*)/g, match => store(`<span class="token-comment">${match}</span>`));
                html = html.replace(keywords, match => `<span class="token-keyword">${match}</span>`);
                html = html.replace(/\b([A-Z][a-zA-Z0-9]*)\b/g, match =>
                `<span class="token-type">${match}</span>`);
                html = html.replace(/\b\d+\b/g, match => `<span class="token-number">${match}</span>`);
                for (let key in placeholders) {
                    html = html.replace(key, placeholders[key]);
                }
                if (text[text.length - 1] === "\n") html += " ";
                return html;
            }

            function sync() {
                const text = $input.val();
                $output.html(highlight(text));
                const lines = text.split('\n').length;
                let numHtml = '';
                for (let i = 1; i <= lines; i++) numHtml += `<div>${i}</div>`;
                $lineNumbers.html(numHtml);
            }

            $input.on('input scroll', sync);

            // Tab support
            $input.on('keydown', function(e) {
                if (e.key === 'Tab') {
                    e.preventDefault();
                    const start = this.selectionStart;
                    const end = this.selectionEnd;
                    $(this).val($(this).val().substring(0, start) + "    " + $(this).val().substring(end));
                    this.selectionStart = this.selectionEnd = start + 4;
                    sync();
                }
            });

            // Run sync immediately to highlight existing code
            sync();
        });
    </script>
</x-app-layout>
