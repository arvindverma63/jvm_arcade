<x-app-layout title="Overview - JVM Arcade" :right-sidebar="false">

    @include('components.profile-header')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <div class="lg:col-span-1 space-y-6">
             @include('components.profile-sidebar')
        </div>

        <div class="lg:col-span-3 space-y-6">

            <div class="grid grid-cols-3 gap-4">
                <div class="bg-brand-card rounded-xl border border-white/5 p-4 text-center">
                    <div class="text-2xl font-bold text-brand-accent">1,337</div>
                    <div class="text-xs text-slate-500 uppercase font-bold tracking-wider">Reputation</div>
                </div>
                <div class="bg-brand-card rounded-xl border border-white/5 p-4 text-center">
                    <div class="text-2xl font-bold text-white">12</div>
                    <div class="text-xs text-slate-500 uppercase font-bold tracking-wider">Snippets</div>
                </div>
                <div class="bg-brand-card rounded-xl border border-white/5 p-4 text-center">
                    <div class="text-2xl font-bold text-white">84</div>
                    <div class="text-xs text-slate-500 uppercase font-bold tracking-wider">Followers</div>
                </div>
            </div>

            <div class="bg-brand-card rounded-xl border border-white/5 p-6">
                <h3 class="text-sm font-bold text-white mb-4">Contribution Activity</h3>
                <div class="flex flex-wrap gap-1">
                    @for($i = 0; $i < 84; $i++)
                        @php $level = rand(0, 4); $colors = ['bg-slate-800', 'bg-green-900', 'bg-green-700', 'bg-green-500', 'bg-brand-accent']; @endphp
                        <div class="w-3 h-3 rounded-sm {{ $colors[$level] }}"></div>
                    @endfor
                </div>
                <div class="mt-2 text-xs text-slate-500">243 contributions in the last year</div>
            </div>

            <div class="bg-brand-card rounded-xl border border-white/5 p-0 overflow-hidden">
                <div class="p-4 border-b border-white/5">
                    <h3 class="text-sm font-bold text-white">Recent Activity</h3>
                </div>
                <div class="divide-y divide-white/5">
                    <div class="p-4 flex gap-4 hover:bg-white/5 transition-colors">
                        <div class="mt-1"><i class="ph-fill ph-code text-brand-accent"></i></div>
                        <div>
                            <p class="text-sm text-slate-300">Created a new snippet <a href="#" class="text-brand-accent hover:underline">Voxel Octree Optimization</a></p>
                            <span class="text-xs text-slate-500">2 hours ago</span>
                        </div>
                    </div>
                    <div class="p-4 flex gap-4 hover:bg-white/5 transition-colors">
                        <div class="mt-1"><i class="ph-fill ph-chat-circle text-blue-400"></i></div>
                        <div>
                            <p class="text-sm text-slate-300">Commented on <a href="#" class="text-white hover:underline">Spring Boot 3.2 migration guide</a></p>
                            <span class="text-xs text-slate-500">1 day ago</span>
                        </div>
                    </div>
                    <div class="p-4 flex gap-4 hover:bg-white/5 transition-colors">
                        <div class="mt-1"><i class="ph-fill ph-heart text-red-500"></i></div>
                        <div>
                            <p class="text-sm text-slate-300">Favorited <a href="#" class="text-white hover:underline">Kotlin Coroutines Cheatsheet</a></p>
                            <span class="text-xs text-slate-500">3 days ago</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
