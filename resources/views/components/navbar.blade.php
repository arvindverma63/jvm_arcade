<nav class="sticky top-0 z-50 glass-effect border-b border-white/10 h-16">
    <div class="max-w-7xl mx-auto px-4 h-full flex items-center justify-between gap-4">
        <a href="/" class="flex items-center gap-2 cursor-pointer group">
            <div
                class="w-8 h-8 rounded-lg bg-gradient-to-br from-orange-600 to-red-600 flex items-center justify-center text-white font-bold shadow-lg shadow-orange-500/20 group-hover:shadow-orange-500/40 transition-all">
                <i class="ph-fill ph-coffee"></i>
            </div>
            <span class="text-white font-bold text-lg tracking-tight hidden sm:block">JVM<span
                    class="text-brand-glow">Arcade</span></span>
        </a>

        <div class="hidden md:flex flex-1 max-w-lg relative">
            <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-500"></i>
            <input type="text" placeholder="Search LibGDX docs, Maven repos, or threads..."
                class="w-full bg-slate-900/50 border border-slate-700 text-sm rounded-full py-2 pl-10 pr-4 focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all placeholder-slate-500 text-slate-200">
        </div>

        <div class="flex items-center gap-3">
            <button class="md:hidden text-slate-400 hover:text-white"><i
                    class="ph ph-magnifying-glass text-xl"></i></button>
            <button class="relative text-slate-400 hover:text-white transition-colors">
                <i class="ph ph-bell text-xl"></i>
                <span
                    class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-brand-java rounded-full border-2 border-brand-dark"></span>
            </button>
            <a href="{{ route('snippets.create') }}"
                class="hidden sm:flex bg-brand-accent hover:bg-amber-600 text-brand-dark text-sm font-bold px-4 py-2 rounded-full transition-all shadow-lg shadow-amber-900/20 items-center gap-2">
                <i class="ph-fill ph-code-block text-lg"></i>
                <span>New Snippet</span>
            </a>
            <a href="{{ route('profile.overview') }}"
                class="w-9 h-9 rounded-full bg-slate-700 border border-slate-600 overflow-hidden cursor-pointer hover:ring-2 hover:ring-brand-accent transition-all">
                <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=JavaDev" alt="User"
                    class="w-full h-full object-cover">
            </a>
        </div>
    </div>
</nav>
