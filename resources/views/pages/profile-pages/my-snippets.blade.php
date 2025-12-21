<x-app-layout title="My Snippets - JVM Arcade" :right-sidebar="false">

    @include('components.profile-header')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <div class="lg:col-span-1 space-y-6">
             @include('components.profile-sidebar')
        </div>

        <div class="lg:col-span-3">

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white">My Snippets</h2>
                <a href="{{ route('snippets.create') }}" class="px-4 py-2 rounded-lg bg-brand-accent text-brand-dark text-sm font-bold hover:bg-brand-glow transition-colors">
                    + New Snippet
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="bg-brand-card rounded-xl border border-white/5 overflow-hidden hover:border-slate-500 transition-all group">
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div class="bg-blue-500/10 text-blue-400 text-[10px] font-bold px-2 py-0.5 rounded border border-blue-500/20">Java</div>
                            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button class="text-slate-500 hover:text-white"><i class="ph-bold ph-pencil-simple"></i></button>
                                <button class="text-slate-500 hover:text-red-500"><i class="ph-bold ph-trash"></i></button>
                            </div>
                        </div>
                        <h3 class="text-base font-bold text-white mb-2 truncate">Efficient Matrix Multiplication</h3>
                        <p class="text-xs text-slate-400 line-clamp-2 mb-3">A specialized method for 4x4 matrix ops using primitive floats to avoid GC overhead.</p>

                        <div class="bg-[#0d1117] p-2 rounded border border-white/5 font-mono text-[10px] text-slate-400 mb-3 opacity-80">
                            public static void mul(float[] a, float[] b) {<br>
                            &nbsp;&nbsp;// optimized logic...<br>
                            }
                        </div>

                        <div class="flex items-center justify-between text-xs text-slate-500">
                            <span><i class="ph-bold ph-heart mr-1"></i> 12 likes</span>
                            <span>2 days ago</span>
                        </div>
                    </div>
                </div>

                <div class="bg-brand-card rounded-xl border border-white/5 overflow-hidden hover:border-slate-500 transition-all group">
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div class="bg-indigo-500/10 text-indigo-400 text-[10px] font-bold px-2 py-0.5 rounded border border-indigo-500/20">Kotlin</div>
                            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button class="text-slate-500 hover:text-white"><i class="ph-bold ph-pencil-simple"></i></button>
                                <button class="text-slate-500 hover:text-red-500"><i class="ph-bold ph-trash"></i></button>
                            </div>
                        </div>
                        <h3 class="text-base font-bold text-white mb-2 truncate">Coroutines Extension Functions</h3>
                        <p class="text-xs text-slate-400 line-clamp-2 mb-3">Helper functions for firing one-off async jobs in game loops.</p>

                        <div class="bg-[#0d1117] p-2 rounded border border-white/5 font-mono text-[10px] text-slate-400 mb-3 opacity-80">
                            fun launchGameJob(block: suspend () -> Unit) {<br>
                            &nbsp;&nbsp;scope.launch(Dispatchers.Default) { ... }<br>
                            }
                        </div>

                        <div class="flex items-center justify-between text-xs text-slate-500">
                            <span><i class="ph-bold ph-heart mr-1"></i> 45 likes</span>
                            <span>1 week ago</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
