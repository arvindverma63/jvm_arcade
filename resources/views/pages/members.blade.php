<x-app-layout title="Community Members - JVM Arcade" :right-sidebar="false">

    <div class="max-w-7xl mx-auto mb-10 text-center">
        <div
            class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-brand-accent/10 mb-4 border border-brand-accent/20">
            <i class="ph-fill ph-users-three text-2xl text-brand-accent"></i>
        </div>
        <h1 class="text-4xl font-extrabold text-white tracking-tight">
            Community Members
        </h1>
        <p class="text-slate-400 mt-3 text-lg max-w-2xl mx-auto">
            Connect with fellow developers, discover new projects, and grow your network in the JVM ecosystem.
        </p>
    </div>

    <div
        class="max-w-7xl mx-auto grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6 px-4">

        @foreach ($users as $user)
            <div class="relative group">

                <a href="{{ route('profile.show', $user->id) }}" class="block h-full">
                    <div
                        class="h-full bg-brand-card border border-white/5 rounded-2xl p-6 flex flex-col items-center text-center transition-all duration-300 group-hover:-translate-y-1 group-hover:border-brand-accent/30 group-hover:shadow-[0_0_20px_rgba(251,191,36,0.1)] relative z-10">

                        <div class="relative mb-4">
                            <img src="{{ $user->avatar ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $user->name }}"
                                class="w-20 h-20 rounded-full border-2 border-slate-700 group-hover:border-brand-accent transition-colors object-cover shadow-lg">
                            <div
                                class="absolute bottom-1 right-1 w-4 h-4 bg-green-500 border-4 border-[#0d1117] rounded-full">
                            </div>
                        </div>

                        <h3
                            class="text-slate-100 font-bold truncate w-full group-hover:text-brand-glow transition-colors">
                            {{ $user->name }}
                        </h3>
                        <p class="text-xs font-medium text-slate-500 mt-1 uppercase tracking-wider">
                            Developer
                        </p>

                        <div
                            class="mt-4 px-3 py-1 rounded-full bg-slate-800/50 border border-white/5 text-xs text-slate-400 group-hover:bg-brand-accent/10 group-hover:text-brand-accent group-hover:border-brand-accent/20 transition-all">
                            {{ $user->followers_count }} Followers
                        </div>
                    </div>
                </a>

                <div
                    class="absolute left-1/2 -translate-x-1/2 top-[95%] w-72 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 ease-out z-50 pt-4 pointer-events-none group-hover:pointer-events-auto">

                    <div class="absolute -top-4 left-0 w-full h-8 bg-transparent"></div>

                    <div class="bg-[#0f172a] border border-slate-600 rounded-xl shadow-2xl relative overflow-hidden">

                        <div
                            class="absolute top-0 left-0 w-full h-20 bg-gradient-to-b from-brand-accent/10 via-brand-accent/5 to-transparent">
                        </div>

                        <div class="p-5 relative">
                            <div class="flex items-center gap-4 mb-5">
                                <img src="{{ $user->avatar ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $user->name }}"
                                    class="w-14 h-14 rounded-full border-2 border-slate-600 shadow-md bg-slate-800">
                                <div>
                                    <h4 class="font-bold text-white text-lg leading-tight">{{ $user->name }}</h4>
                                    <span class="text-xs text-brand-accent font-medium">@
                                        {{ Str::slug($user->name) }}</span>
                                </div>
                            </div>

                            <div
                                class="grid grid-cols-3 gap-2 py-3 bg-slate-800/50 rounded-lg border border-white/5 mb-5 backdrop-blur-sm">
                                <div class="text-center border-r border-white/5">
                                    <div class="text-white font-bold text-lg">{{ $user->snippets_count }}</div>
                                    <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Code
                                    </div>
                                </div>
                                <div class="text-center border-r border-white/5">
                                    <div class="text-white font-bold text-lg follower-count-{{ $user->id }}">
                                        {{ $user->followers_count }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Fans
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="text-white font-bold text-lg">{{ $user->following_count }}</div>
                                    <div class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Following
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <button onclick="toggleFollowMember('{{ $user->id }}', this)"
                                    class="w-full py-2 rounded-lg font-bold text-sm transition-all flex items-center justify-center gap-2 shadow-lg
                                    {{ Auth::user()->isFollowing($user)
                                        ? 'bg-slate-700 text-slate-300 hover:bg-slate-600 shadow-none'
                                        : 'bg-brand-accent text-brand-dark hover:bg-brand-glow hover:-translate-y-0.5 shadow-brand-accent/20' }}">
                                    <i
                                        class="{{ Auth::user()->isFollowing($user) ? 'ph-bold ph-check' : 'ph-bold ph-user-plus' }} text-lg"></i>
                                    <span
                                        class="btn-text">{{ Auth::user()->isFollowing($user) ? 'Following' : 'Follow' }}</span>
                                </button>

                                <div class="flex gap-2">
                                    <a href="{{ route('profile.show', $user->id) }}"
                                        class="flex-1 py-2 rounded-lg bg-slate-800 border border-slate-600 text-slate-300 text-xs font-bold hover:bg-slate-700 hover:text-white transition-colors flex items-center justify-center gap-2">
                                        <i class="ph-bold ph-user text-base"></i> Profile
                                    </a>

                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open"
                                            class="h-full px-3 rounded-lg bg-slate-800 border border-slate-600 text-slate-400 hover:text-red-400 hover:border-red-500/50 hover:bg-red-500/10 transition-colors">
                                            <i class="ph-bold ph-dots-three-vertical text-lg"></i>
                                        </button>

                                        <div x-show="open" @click.away="open = false"
                                            class="absolute right-0 bottom-full mb-2 w-36 bg-slate-900 border border-slate-700 rounded-lg shadow-xl overflow-hidden z-[60]"
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="opacity-0 scale-95"
                                            x-transition:enter-end="opacity-100 scale-100" style="display: none;">
                                            <button onclick="toggleBlockMember('{{ $user->id }}')"
                                                class="w-full text-left px-4 py-3 text-xs font-bold text-red-400 hover:bg-red-500/10 hover:text-red-300 flex items-center gap-2">
                                                <i class="ph-bold ph-prohibit text-sm"></i> Block User
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <div class="mt-12 max-w-7xl mx-auto px-4 pb-8">
        {{ $users->links() }}
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        function toggleFollowMember(userId, btn) {
            $.ajax({
                url: `/users/${userId}/follow`,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    const textSpan = btn.querySelector('.btn-text');
                    const icon = btn.querySelector('i');

                    if (res.status === 'followed') {
                        btn.className =
                            "w-full py-2 rounded-lg font-bold text-sm transition-all flex items-center justify-center gap-2 shadow-none bg-slate-700 text-slate-300 hover:bg-slate-600";
                        textSpan.innerText = "Following";
                        icon.className = "ph-bold ph-check text-lg";
                    } else {
                        btn.className =
                            "w-full py-2 rounded-lg font-bold text-sm transition-all flex items-center justify-center gap-2 shadow-lg bg-brand-accent text-brand-dark hover:bg-brand-glow hover:-translate-y-0.5 shadow-brand-accent/20";
                        textSpan.innerText = "Follow";
                        icon.className = "ph-bold ph-user-plus text-lg";
                    }
                    $(`.follower-count-${userId}`).text(res.followers_count);
                },
                error: function() {
                    alert('Error processing request.');
                }
            });
        }

        function toggleBlockMember(userId) {
            if (!confirm('Are you sure you want to block this user?')) return;
            $.ajax({
                url: `/users/${userId}/block`,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    window.location.reload();
                }
            });
        }
    </script>

</x-app-layout>
