<x-app-layout title="SpriteBatch Flushing Issue - JVM Arcade" :right-sidebar="false">

    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('home') }}"
            class="flex items-center gap-2 text-sm text-slate-500 hover:text-white transition-colors">
            <i class="ph ph-arrow-left"></i> Back to Feed
        </a>
        <div class="flex gap-2">
            <button
                class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-800 text-slate-300 text-xs font-bold hover:bg-slate-700 transition-colors">
                <i class="ph ph-bell"></i> Subscribe
            </button>
            <button
                class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-brand-accent/10 text-brand-accent text-xs font-bold hover:bg-brand-accent/20 transition-colors">
                <i class="ph ph-share-network"></i> Share
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <div class="lg:col-span-9 space-y-6">

            <div class="bg-brand-card rounded-xl border border-white/5 overflow-hidden">
                <div class="p-6 flex gap-4">

                    <div class="flex flex-col items-center gap-2 pt-1 w-10 shrink-0">
                        <button
                            class="text-slate-500 hover:text-brand-accent hover:bg-brand-accent/10 p-1.5 rounded transition-colors">
                            <i class="ph-bold ph-caret-up text-2xl"></i>
                        </button>
                        <span class="text-xl font-bold text-white">42</span>
                        <button
                            class="text-slate-500 hover:text-red-400 hover:bg-red-400/10 p-1.5 rounded transition-colors">
                            <i class="ph-bold ph-caret-down text-2xl"></i>
                        </button>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h1 class="text-2xl font-bold text-white leading-tight mb-2">Why is my SpriteBatch
                                    flushing so often?</h1>
                                <div class="flex flex-wrap items-center gap-2">
                                    <span
                                        class="bg-red-500/10 text-red-400 text-xs px-2 py-0.5 rounded border border-red-500/20 font-mono">LibGDX</span>
                                    <span
                                        class="bg-slate-700/50 text-slate-400 text-xs px-2 py-0.5 rounded border border-slate-600 font-mono">Rendering</span>
                                    <span
                                        class="bg-slate-700/50 text-slate-400 text-xs px-2 py-0.5 rounded border border-slate-600 font-mono">Performance</span>
                                </div>
                            </div>
                            <span class="text-xs text-slate-500 whitespace-nowrap">Asked 4 hours ago</span>
                        </div>

                        <div class="prose prose-invert prose-sm max-w-none text-slate-300 mb-6">
                            <p>I'm trying to optimize my 2D renderer in LibGDX. I've packed all my textures into a
                                single Atlas, but I'm still getting high draw calls (around 150) for a simple scene.</p>
                            <p>Here is my render loop. Am I breaking the batch somewhere?</p>
                        </div>

                        <div class="rounded-lg border border-slate-700 overflow-hidden bg-[#0d1117] mb-6">
                            <div
                                class="flex items-center justify-between bg-slate-800/50 border-b border-slate-700 px-4 py-2">
                                <span class="text-xs text-slate-500 font-mono">GameScreen.java</span>
                                <button class="text-xs text-slate-500 hover:text-white flex items-center gap-1"><i
                                        class="ph ph-copy"></i> Copy</button>
                            </div>
                            <div class="p-4 overflow-x-auto">
                                <pre class="font-mono text-sm leading-relaxed text-slate-300">
<span class="text-brand-accent">public void</span> <span class="text-blue-300">render</span>(<span class="text-brand-accent">float</span> delta) {
    <span class="text-slate-500">// Clear Screen</span>
    ScreenUtils.clear(0, 0, 0, 1);

    camera.update();
    batch.setProjectionMatrix(camera.combined);

    batch.begin();
    <span class="text-brand-accent">for</span> (Entity e : entities) {
        <span class="text-slate-500">// Is this causing the flush?</span>
        e.getTexture().setFilter(TextureFilter.Linear, TextureFilter.Linear);
        batch.draw(e.getTexture(), e.x, e.y);
    }
    batch.end();
}
</pre>
                            </div>
                        </div>

                        <div class="flex items-center justify-between border-t border-white/5 pt-4">
                            <button class="text-slate-500 text-xs hover:text-white flex items-center gap-1">
                                <i class="ph-fill ph-flag"></i> Report
                            </button>

                            <div
                                class="flex items-center gap-3 bg-slate-800/50 rounded-lg p-2 pr-4 border border-white/5">
                                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Jack"
                                    class="w-8 h-8 rounded-full bg-slate-700">
                                <div>
                                    <div class="text-xs text-slate-400">Asked by</div>
                                    <a href="#"
                                        class="text-sm font-bold text-brand-accent hover:underline">CodeWizard</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-8 mb-4">
                <h3 class="text-lg font-bold text-white">2 Answers</h3>
                <div class="flex items-center gap-2 text-sm text-slate-400">
                    <span>Sort by:</span>
                    <select class="bg-transparent border-none text-white font-bold text-sm focus:ring-0 cursor-pointer">
                        <option>Highest Score</option>
                        <option>Newest</option>
                    </select>
                </div>
            </div>

            <div class="bg-brand-card/50 rounded-xl border border-brand-success/30 relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 bg-brand-success text-brand-dark text-[10px] font-bold px-2 py-1 rounded-bl-lg flex items-center gap-1">
                    <i class="ph-fill ph-check"></i> Solution
                </div>

                <div class="p-6 flex gap-4">
                    <div class="flex flex-col items-center gap-2 pt-1 w-10 shrink-0">
                        <button class="text-brand-success hover:bg-brand-success/10 p-1.5 rounded transition-colors">
                            <i class="ph-bold ph-caret-up text-2xl"></i>
                        </button>
                        <span class="text-xl font-bold text-white">15</span>
                        <button
                            class="text-slate-500 hover:text-red-400 hover:bg-red-400/10 p-1.5 rounded transition-colors">
                            <i class="ph-bold ph-caret-down text-2xl"></i>
                        </button>
                        <i class="ph-fill ph-check-circle text-brand-success text-2xl mt-2"></i>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="prose prose-invert prose-sm max-w-none text-slate-300 mb-4">
                            <p>Yes, calling <code>setFilter</code> inside your render loop is absolutely breaking the
                                batch!</p>
                            <p>Changing texture state forces the <code>SpriteBatch</code> to flush (send geometry to
                                GPU) immediately. You should set the filter once when you load the texture, not every
                                frame.</p>
                        </div>

                        <div class="flex items-center justify-end gap-3 mt-4">
                            <div class="text-right">
                                <div class="text-xs text-slate-400">Answered 2h ago</div>
                                <a href="#"
                                    class="text-sm font-bold text-white hover:text-brand-accent">GarbageCollector</a>
                            </div>
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix"
                                class="w-8 h-8 rounded-full border border-brand-success/50">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-brand-card rounded-xl border border-white/5 p-6 flex gap-4">
                <div class="flex flex-col items-center gap-2 pt-1 w-10 shrink-0">
                    <button
                        class="text-slate-500 hover:text-brand-accent hover:bg-brand-accent/10 p-1.5 rounded transition-colors">
                        <i class="ph-bold ph-caret-up text-2xl"></i>
                    </button>
                    <span class="text-xl font-bold text-slate-400">2</span>
                    <button
                        class="text-slate-500 hover:text-red-400 hover:bg-red-400/10 p-1.5 rounded transition-colors">
                        <i class="ph-bold ph-caret-down text-2xl"></i>
                    </button>
                </div>
                <div class="flex-1">
                    <div class="prose prose-invert prose-sm max-w-none text-slate-300 mb-4">
                        <p>Also, make sure your projection matrix isn't being set multiple times if you have multiple
                            cameras.</p>
                    </div>
                    <div class="flex items-center justify-end gap-3 mt-4">
                        <div class="text-right">
                            <div class="text-xs text-slate-400">Answered 3h ago</div>
                            <a href="#" class="text-sm font-bold text-slate-300 hover:text-white">NewbieDev</a>
                        </div>
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Junior"
                            class="w-8 h-8 rounded-full opacity-60">
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-lg font-bold text-white mb-4">Your Answer</h3>
                <div class="bg-brand-card rounded-xl border border-white/5 p-4">
                    <div class="flex gap-2 border-b border-white/5 pb-2 mb-3">
                        <button class="p-1.5 text-slate-400 hover:text-white hover:bg-white/5 rounded"><i
                                class="ph-bold ph-text-b"></i></button>
                        <button class="p-1.5 text-slate-400 hover:text-white hover:bg-white/5 rounded"><i
                                class="ph-bold ph-text-italic"></i></button>
                        <button class="p-1.5 text-slate-400 hover:text-white hover:bg-white/5 rounded"><i
                                class="ph-bold ph-code"></i></button>
                        <div class="w-px h-6 bg-white/10 mx-1"></div>
                        <button class="p-1.5 text-slate-400 hover:text-white hover:bg-white/5 rounded"><i
                                class="ph-bold ph-image"></i></button>
                    </div>

                    <textarea rows="6"
                        class="w-full bg-transparent border-none text-slate-200 focus:ring-0 placeholder-slate-600 resize-y"
                        placeholder="Type your solution here... Use Markdown blocks for code."></textarea>

                    <div class="flex justify-between items-center border-t border-white/5 pt-3 mt-2">
                        <span class="text-xs text-slate-500">Supports Markdown</span>
                        <button
                            class="bg-brand-accent hover:bg-brand-glow text-brand-dark font-bold px-6 py-2 rounded-lg transition-colors">
                            Post Answer
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <div class="lg:col-span-3 space-y-6">

            <div class="bg-brand-card rounded-xl border border-white/5 p-4">
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div>
                        <div class="text-2xl font-bold text-white">156</div>
                        <div class="text-xs text-slate-500 uppercase font-bold">Views</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-brand-accent">2</div>
                        <div class="text-xs text-slate-500 uppercase font-bold">Answers</div>
                    </div>
                </div>
            </div>

            <div class="bg-brand-card rounded-xl border border-white/5 p-4">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Related Threads</h3>
                <div class="space-y-3">
                    <a href="#" class="block group">
                        <div
                            class="text-sm font-medium text-slate-300 group-hover:text-brand-accent transition-colors">
                            Texture packing best practices?</div>
                        <div class="text-xs text-slate-500 mt-0.5 bg-slate-800 inline-block px-1.5 rounded">LibGDX
                        </div>
                    </a>
                    <div class="border-t border-white/5"></div>
                    <a href="#" class="block group">
                        <div
                            class="text-sm font-medium text-slate-300 group-hover:text-brand-accent transition-colors">
                            FrameBuffer causing black screen on iOS</div>
                        <div class="text-xs text-slate-500 mt-0.5 bg-slate-800 inline-block px-1.5 rounded">Mobile
                        </div>
                    </a>
                    <div class="border-t border-white/5"></div>
                    <a href="#" class="block group">
                        <div
                            class="text-sm font-medium text-slate-300 group-hover:text-brand-accent transition-colors">
                            How to use ShapeRenderer with Scene2D</div>
                        <div class="text-xs text-slate-500 mt-0.5 bg-slate-800 inline-block px-1.5 rounded">UI</div>
                    </a>
                </div>
            </div>

        </div>
    </div>

</x-app-layout>
