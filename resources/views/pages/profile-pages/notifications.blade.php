<x-app-layout title="Notifications - JVM Arcade" :right-sidebar="false">

    @include('components.profile-header')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <div class="lg:col-span-1 space-y-6">
             @include('components.profile-sidebar')
        </div>

        <div class="lg:col-span-3">
            <div class="bg-brand-card rounded-xl border border-white/5 overflow-hidden">

                <div class="flex items-center justify-between p-4 border-b border-white/5">
                    <h2 class="text-lg font-bold text-white">Notifications</h2>
                    <button class="text-xs text-brand-accent hover:text-white transition-colors">Mark all as read</button>
                </div>

                <div class="divide-y divide-white/5">

                    <div class="p-4 bg-brand-accent/5 flex gap-4 group cursor-pointer hover:bg-brand-accent/10 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center shrink-0">
                            <i class="ph-fill ph-chat-circle text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-slate-200">
                                <span class="font-bold text-white">CodeMaster_99</span> replied to your discussion <span class="font-medium text-brand-accent">"Best way to handle UDP packets?"</span>
                            </p>
                            <p class="text-xs text-slate-500 mt-1">"Actually, Netty handles this automatically if you use the..."</p>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <span class="text-xs text-slate-400">10m ago</span>
                            <div class="w-2 h-2 rounded-full bg-brand-accent"></div>
                        </div>
                    </div>

                    <div class="p-4 flex gap-4 group cursor-pointer hover:bg-white/5 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-red-500/20 text-red-400 flex items-center justify-center shrink-0">
                            <i class="ph-fill ph-heart text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-slate-300">
                                <span class="font-bold text-slate-200">SarahDev</span> liked your snippet <span class="font-medium text-white">"Java 21 Virtual Threads"</span>
                            </p>
                        </div>
                        <span class="text-xs text-slate-500">2h ago</span>
                    </div>

                    <div class="p-4 flex gap-4 group cursor-pointer hover:bg-white/5 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-brand-java/20 text-brand-java flex items-center justify-center shrink-0">
                            <i class="ph-fill ph-trophy text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-slate-300">
                                You earned the <span class="font-bold text-brand-glow">100 Reputation</span> badge!
                            </p>
                        </div>
                        <span class="text-xs text-slate-500">1d ago</span>
                    </div>

                </div>

                <div class="p-4 border-t border-white/5 text-center">
                    <button class="text-sm text-slate-500 hover:text-white transition-colors">Load older notifications</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
