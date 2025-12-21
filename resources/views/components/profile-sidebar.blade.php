<nav class="bg-brand-card rounded-xl border border-white/5 overflow-hidden p-2 space-y-1 sticky top-24">

    <a href="{{ route('profile.overview') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('profile.overview') ? 'bg-brand-accent/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
        <i class="{{ request()->routeIs('profile.overview') ? 'ph-fill' : 'ph' }} ph-user text-lg"></i> Overview
    </a>

    <a href="{{ route('profile.snippets') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('profile.snippets') ? 'bg-brand-accent/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
        <i class="{{ request()->routeIs('profile.snippets') ? 'ph-fill' : 'ph' }} ph-code-block text-lg"></i> My Snippets
    </a>

    <a href="{{ route('profile.notifications') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('profile.notifications') ? 'bg-brand-accent/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
        <i class="{{ request()->routeIs('profile.notifications') ? 'ph-fill' : 'ph' }} ph-bell text-lg"></i>
        Notifications
    </a>

    <div class="border-t border-slate-700/50 my-1"></div>

    <a href="{{ route('profile.settings') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('profile.settings') ? 'bg-brand-accent/10 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
        <i class="{{ request()->routeIs('profile.settings') ? 'ph-fill' : 'ph' }} ph-gear text-lg"></i> Settings
    </a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="w-full flex items-center gap-3 px-3 py-2 text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-lg transition-colors text-left">
            <i class="ph ph-sign-out text-lg"></i> Log Out
        </button>
    </form>
</nav>
