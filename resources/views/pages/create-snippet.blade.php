<x-app-layout title="New Snippet - JVM Arcade" :right-sidebar="false">
    @include('pages.snippet.style')



    <div class="max-w-5xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                    <i class="ph-fill ph-code-block text-brand-accent"></i>
                    Create New Snippet
                </h1>
                <p class="text-slate-400 text-sm mt-1">Share your code, config, or helper functions.</p>
            </div>
            <a href="{{ route('profile.snippets') }}"
                class="text-sm text-slate-500 hover:text-white transition-colors">Cancel</a>
        </div>

        <div class="bg-brand-card border border-white/5 rounded-xl overflow-hidden shadow-xl">
            <form action="{{ route('snippets.store') }}" method="POST" class="p-6 space-y-6" id="create-snippet-form">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Title</label>
                        <input type="text" name="title" required placeholder="e.g. Efficient Matrix Multiplication"
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
                                <option value="Java">Java</option>
                                <option value="Kotlin">Kotlin</option>
                                <option value="Scala">Scala</option>
                                <option value="Groovy">Groovy</option>
                                <option value="JSON">XML / JSON</option>
                            </select>
                            <i
                                class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none"></i>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Code</label>
                        <span
                            class="text-[10px] text-slate-500 bg-slate-800 px-2 py-0.5 rounded border border-slate-700">
                            Auto-close: { } [ ] ( ) " '
                        </span>
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
                                id="filename-display">Snippet.java</span>
                        </div>

                        <div class="flex relative bg-[#0d1117]">
                            <div id="line-numbers"
                                class="mono-font hidden sm:flex flex-col items-end gap-0 pt-3 pr-2 pl-3 bg-slate-800/20 text-slate-600 select-none border-r border-slate-800 w-10 shrink-0 text-right h-[320px] overflow-hidden">
                                1
                            </div>
                            <div class="editor-wrapper">
                                <pre id="syntax-highlight" class="editor-layer syntax-layer mono-font"><code id="code-output"></code></pre>
                                <textarea name="code" id="code-input" required spellcheck="false" autocomplete="off" data-gramm="false"
                                    class="editor-layer input-layer mono-font" placeholder="// Start typing..."></textarea>
                            </div>
                        </div>
                    </div>
                    @error('code')
                        <span class="text-red-400 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Description</label>
                    <input type="hidden" name="description" id="quill-content-input">
                    <div id="quill-wrapper">
                        <div id="quill-editor-container"></div>
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

                    <p class="text-[10px] text-slate-500">Press <b>Comma</b> or <b>Enter</b> to add a tag. Backspace to
                        remove.</p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-700/50">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg text-sm font-bold bg-brand-accent text-brand-dark hover:bg-brand-glow shadow-lg shadow-brand-accent/20 transition-all flex items-center gap-2">
                        <i class="ph-bold ph-paper-plane-right"></i>
                        Publish Snippet
                    </button>
                </div>

            </form>
        </div>
    </div>

    @include('pages.snippet.script')
</x-app-layout>
