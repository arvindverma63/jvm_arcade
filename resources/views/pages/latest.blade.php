<x-app-layout title="Latest Activity - JVM Arcade">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-2">
            <div class="p-2 bg-brand-accent/10 rounded-lg text-brand-accent">
                <i class="ph-fill ph-clock-counter-clockwise text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-white leading-tight">Latest Activity</h1>
                <p class="text-xs text-slate-500">Real-time updates from the community</p>
            </div>
        </div>

        <div class="flex items-center bg-brand-card rounded-lg border border-white/5 p-1">
            <button class="px-3 py-1.5 rounded-md bg-slate-700 text-white text-xs font-bold shadow-sm">All</button>
            <button
                class="px-3 py-1.5 rounded-md text-slate-400 hover:text-white text-xs font-medium transition-colors">Posts</button>
            <button
                class="px-3 py-1.5 rounded-md text-slate-400 hover:text-white text-xs font-medium transition-colors">Questions</button>
            <div class="w-px h-4 bg-slate-700 mx-1"></div>
            <button class="px-2 py-1.5 text-slate-500 hover:text-brand-accent transition-colors">
                <i class="ph ph-sliders text-sm"></i>
            </button>
        </div>
    </div>

    <div class="space-y-4 relative">

        <div class="absolute left-6 top-4 bottom-4 w-px bg-slate-800 -z-10 hidden sm:block"></div>

        <div
            class="bg-brand-card rounded-xl border border-white/5 p-0 overflow-hidden hover:border-brand-accent/30 transition-all group">
            <div class="p-5 flex gap-4">
                <div class="flex-shrink-0 z-10">
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Sarah"
                        class="w-10 h-10 rounded-full ring-4 ring-brand-card">
                </div>

                <div class="flex-1">
                    <div class="flex items-baseline justify-between mb-1">
                        <div class="flex items-center gap-2">
                            <span
                                class="font-bold text-slate-200 text-sm hover:text-brand-accent cursor-pointer">VoxelQueen</span>
                            <span class="text-slate-600 text-xs">•</span>
                            <span class="text-slate-500 text-xs">28 min ago</span>
                        </div>
                        <span
                            class="bg-purple-500/10 text-purple-400 text-[10px] font-bold px-2 py-0.5 rounded border border-purple-500/20 uppercase">Showcase</span>
                    </div>

                    <h3 class="text-base font-semibold text-slate-100 mb-2">Finally got the lighting engine working! 🔦
                    </h3>
                    <p class="text-sm text-slate-400 mb-3">Implemented deferred rendering in LWJGL. The dynamic shadows
                        are finally crisp without killing the framerate.</p>

                    <div
                        class="relative w-full h-48 bg-slate-900 rounded-lg overflow-hidden border border-white/5 group-hover:border-white/10 transition-colors mb-3">
                        <div
                            class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-slate-800 to-slate-900">
                            <div class="text-center">
                                <i class="ph-fill ph-image text-4xl text-slate-700 mb-2"></i>
                                <span class="block text-xs text-slate-600 font-mono">screenshot_001.png</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 border-t border-white/5 pt-3 mt-1">
                        <button
                            class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-brand-accent transition-colors group/btn">
                            <i class="ph ph-heart text-base group-hover/btn:scale-110 transition-transform"></i> 84
                        </button>
                        <button
                            class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-white transition-colors">
                            <i class="ph ph-chat-circle text-base"></i> 6 Comments
                        </button>
                        <button
                            class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-white transition-colors ml-auto">
                            <i class="ph ph-share-network text-base"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="bg-brand-card rounded-xl border border-white/5 p-5 hover:border-slate-600 transition-all relative overflow-hidden">
            <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-bl from-brand-success/10 to-transparent"></div>

            <div class="flex gap-4">
                <div class="flex-shrink-0 z-10">
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Mike"
                        class="w-10 h-10 rounded-full ring-4 ring-brand-card">
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-bold text-slate-200 text-sm">ServerGuy_99</span>
                        <span class="text-slate-500 text-xs">1 hour ago</span>
                        <span
                            class="bg-brand-success/10 text-brand-success text-[10px] font-bold px-2 py-0.5 rounded border border-brand-success/20 uppercase ml-auto">Help
                            Wanted</span>
                    </div>

                    <h3 class="text-base font-semibold text-white mb-1">Netty expert needed for MMO architecture</h3>
                    <p class="text-sm text-slate-400">Looking for someone who understands Netty pipeline handlers
                        deeply. We are hitting a bottleneck with packet serialization.</p>

                    <div class="flex gap-2 mt-3">
                        <span class="text-[10px] font-mono bg-slate-800 text-slate-400 px-2 py-1 rounded">#java</span>
                        <span class="text-[10px] font-mono bg-slate-800 text-slate-400 px-2 py-1 rounded">#netty</span>
                        <span
                            class="text-[10px] font-mono bg-slate-800 text-slate-400 px-2 py-1 rounded">#backend</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-brand-card rounded-xl border border-white/5 p-5 hover:border-slate-600 transition-all">
            <div class="flex gap-4">
                <div class="flex-shrink-0 z-10">
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Junior"
                        class="w-10 h-10 rounded-full ring-4 ring-brand-card grayscale opacity-70">
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-bold text-slate-200 text-sm">NewbieDev</span>
                        <span class="text-slate-500 text-xs">3 hours ago</span>
                    </div>

                    <h3 class="text-base font-semibold text-slate-100 mb-2">Why is this Stream returning empty?</h3>

                    <div class="code-preview border-l-brand-java">
                        <span class="java-comment">// Trying to filter nulls</span><br>
                        list.stream()<br>
                        &nbsp;&nbsp;.filter(x -> x != <span class="java-keyword">null</span>)<br>
                        &nbsp;&nbsp;.map(<span class="java-type">String</span>::toUpperCase)<br>
                        &nbsp;&nbsp;.collect(<span class="java-type">Collectors</span>.toList());
                    </div>

                    <div class="flex items-center gap-4 mt-3 pt-2">
                        <button
                            class="flex items-center gap-1.5 text-xs text-brand-accent hover:text-brand-glow transition-colors">
                            <i class="ph-fill ph-check-circle text-base"></i> Solved
                        </button>
                        <span class="text-slate-600 text-xs">•</span>
                        <button
                            class="flex items-center gap-1.5 text-xs text-slate-500 hover:text-white transition-colors">
                            <i class="ph ph-chat-circle text-base"></i> 3 Answers
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-8 text-center">
        <button
            class="px-6 py-2.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-medium border border-slate-700 transition-all hover:shadow-lg">
            Load Older Activities
        </button>
    </div>

</x-app-layout>
