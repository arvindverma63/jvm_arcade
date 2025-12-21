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

    <div
        class="glass-effect rounded-xl p-5 border-l-4 border-brand-java relative overflow-hidden group hover:border-red-500 transition-all cursor-pointer mb-4">
        <div class="absolute top-0 right-0 p-3 opacity-10 group-hover:opacity-20 transition-opacity">
            <i class="ph-fill ph-coffee-bean text-6xl text-brand-java"></i>
        </div>
        <div class="flex items-start gap-4">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-1">
                    <span
                        class="bg-brand-java/10 text-brand-java text-[10px] font-bold px-2 py-0.5 rounded border border-brand-java/20 uppercase tracking-wide">News</span>
                    <span class="text-slate-500 text-xs flex items-center gap-1">
                        <i class="ph ph-clock"></i> 4h ago
                    </span>
                </div>
                <h2 class="text-lg font-bold text-white mb-2 group-hover:text-brand-glow transition-colors">
                    Java 21+ Game Loop Performance Benchmarks
                </h2>
                <p class="text-slate-400 text-sm line-clamp-2">
                    The new Generational ZGC is a game changer for avoiding stutter. We benchmarked a voxel engine with
                    500k entities...
                </p>
            </div>
        </div>
    </div>

    <a href="{{ route('post.show', ['id' => 1]) }}" class="block">
        <div
            class="bg-brand-card rounded-xl p-5 border border-white/5 hover:border-slate-600 transition-all cursor-pointer group">
            <div class="flex gap-4">
                <div class="flex flex-col items-center gap-1">
                    <button
                        class="text-slate-500 hover:text-brand-accent hover:bg-brand-accent/10 p-1 rounded transition-colors">
                        <i class="ph ph-caret-up text-xl"></i>
                    </button>
                    <span class="text-sm font-bold text-white">42</span>
                    <button class="text-slate-500 hover:text-red-400 hover:bg-red-400/10 p-1 rounded transition-colors">
                        <i class="ph ph-caret-down text-xl"></i>
                    </button>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span
                            class="bg-red-500/10 text-red-400 text-xs px-2 py-0.5 rounded border border-red-500/20">LibGDX</span>
                        <span
                            class="bg-slate-700/50 text-slate-400 text-xs px-2 py-0.5 rounded border border-slate-600">Rendering</span>
                        <span class="text-slate-600 text-xs">•</span>
                        <div class="flex items-center gap-1.5">
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Jack"
                                class="w-4 h-4 rounded-full">
                            <span class="text-xs text-slate-400 hover:text-white transition-colors">CodeWizard</span>
                        </div>
                    </div>

                    <h3
                        class="text-base font-semibold text-slate-100 mb-2 group-hover:text-brand-glow transition-colors">
                        Why is my SpriteBatch flushing so often?
                    </h3>
                    <p class="text-sm text-slate-400 mb-3">
                        I'm trying to optimize my 2D renderer. Keep getting high draw calls even though textures are
                        packed.
                    </p>

                    <div class="code-preview border-l-brand-java">
                        <span class="java-comment">// Render Loop</span><br>
                        <span class="java-keyword">public void</span> <span class="text-blue-300">render</span>() {<br>
                        &nbsp;&nbsp;<span class="java-type">ScreenUtils</span>.clear(<span
                            class="text-purple-400">0</span>, <span class="text-purple-400">0</span>, <span
                            class="text-purple-400">0</span>, <span class="text-purple-400">1</span>);<br>
                        &nbsp;&nbsp;batch.begin();<br>
                        &nbsp;&nbsp;<span class="java-keyword">for</span> (<span class="java-type">Entity</span> e :
                        entities) {<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;batch.draw(e.getTexture(), e.x, e.y);<br>
                        &nbsp;&nbsp;}<br>
                        &nbsp;&nbsp;batch.end();<br>
                        }
                    </div>

                    <div class="flex items-center gap-4 mt-4">
                        <button
                            class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-slate-300 transition-colors">
                            <i class="ph ph-chat-circle text-base"></i> 12 Comments
                        </button>
                        <button
                            class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-slate-300 transition-colors ml-auto">
                            <i class="ph ph-bookmark-simple text-base"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </a>

</x-app-layout>
