    <div class="fixed bottom-0 w-full bg-brand-card/90 backdrop-blur-lg border-t border-white/10 md:hidden z-50">
        <div class="flex justify-around items-center h-16">
            <a href="{{ route('home') }}"
                class="flex flex-col items-center gap-1 {{ request()->routeIs('home') ? 'text-brand-accent' : 'text-slate-500' }}">
                <i class="{{ request()->routeIs('home') ? 'ph-fill' : 'ph' }} ph-house text-xl"></i>
                <span class="text-[10px] font-medium">Feed</span>
            </a>
            <a href="#" class="flex flex-col items-center text-slate-500 hover:text-slate-200 gap-1">
                <i class="ph ph-code text-xl"></i>
                <span class="text-[10px] font-medium">Libs</span>
            </a>
            <a href="#" class="flex flex-col items-center text-slate-500 hover:text-slate-200 gap-1">
                <div
                    class="w-10 h-10 bg-brand-accent rounded-full flex items-center justify-center -mt-4 shadow-lg border-4 border-brand-dark text-brand-dark">
                    <i class="ph-fill ph-plus text-xl"></i>
                </div>
            </a>
            <a href="#" class="flex flex-col items-center text-slate-500 hover:text-slate-200 gap-1">
                <i class="ph ph-chats text-xl"></i>
                <span class="text-[10px] font-medium">Forum</span>
            </a>
            <a href="{{ route('profile.overview') }}"
                class="flex flex-col items-center gap-1 {{ request()->routeIs('profile.overview') ? 'text-brand-accent' : 'text-slate-500 hover:text-slate-200' }}">
                <i class="{{ request()->routeIs('profile.overview') ? 'ph-fill' : 'ph' }} ph-user text-xl"></i>
                <span class="text-[10px] font-medium">Me</span>
            </a>
        </div>
    </div>
