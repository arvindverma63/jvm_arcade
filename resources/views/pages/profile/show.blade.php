<x-app-layout title="{{ $user->name }} - Profile" :right-sidebar="false">

    <div x-data="{ activeTab: 'snippets' }">

        {{-- 1. PROFILE HEADER --}}
        <div class="relative mb-8">

            {{-- Banner Image --}}
            <div class="h-64 w-full rounded-2xl overflow-hidden relative group">
                <img src="{{ $user->banner ?? 'https://images.unsplash.com/photo-1550684848-fac1c5b4e853?q=80&w=2670&auto=format&fit=crop' }}"
                    class="w-full h-full object-cover">

                <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-transparent to-transparent opacity-90">
                </div>

                {{-- Edit Banner Form (Owner Only) --}}
                @if (Auth::id() === $user->id)
                    <form action="{{ route('profile.image.update') }}" method="POST" enctype="multipart/form-data"
                        class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-all z-20">
                        @csrf
                        <label
                            class="bg-black/50 hover:bg-black/70 text-white px-3 py-1.5 rounded-lg text-xs font-bold backdrop-blur-md cursor-pointer flex items-center gap-2 transition-colors">
                            <i class="ph-bold ph-camera"></i> Edit Banner
                            <input type="file" name="banner" class="hidden" onchange="this.form.submit()"
                                accept="image/*">
                        </label>
                    </form>
                @endif
            </div>

            {{-- Info Bar & Avatar --}}
            <div class="px-6 relative -mt-16 flex flex-col md:flex-row items-end md:items-center gap-6">

                {{-- Avatar --}}
                <div class="relative shrink-0">
                    <img src="{{ $user->avatar ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $user->name }}"
                        class="w-32 h-32 rounded-full border-4 border-[#0f172a] shadow-2xl bg-[#0f172a] object-cover">

                    {{-- Edit Avatar Form (Owner Only) --}}
                    @if (Auth::id() === $user->id)
                        <form action="{{ route('profile.image.update') }}" method="POST" enctype="multipart/form-data"
                            class="absolute bottom-1 right-1 z-20">
                            @csrf
                            <label
                                class="bg-brand-accent text-brand-dark p-2 rounded-full shadow-lg hover:bg-white transition-colors cursor-pointer flex items-center justify-center">
                                <i class="ph-bold ph-pencil-simple"></i>
                                <input type="file" name="avatar" class="hidden" onchange="this.form.submit()"
                                    accept="image/*">
                            </label>
                        </form>
                    @endif
                </div>

                {{-- User Text Info --}}
                <div class="flex-1 pb-2">
                    <h1 class="text-3xl font-bold text-white mb-1">{{ $user->name }}</h1>
                    <p class="text-slate-400 text-sm max-w-xl">{{ $user->bio ?? 'Full Stack Developer.' }}</p>
                    <div class="flex items-center gap-4 mt-3 text-xs font-bold text-slate-500 uppercase tracking-wide">
                        <span class="flex items-center gap-1"><i class="ph-fill ph-calendar-blank"></i> Joined
                            {{ $user->created_at->format('M Y') }}</span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3 pb-4">
                    @if (Auth::id() !== $user->id)
                        {{-- Follow Button --}}
                        <button onclick="toggleFollowMember('{{ $user->id }}', this)"
                            class="px-6 py-2 rounded-lg font-bold text-sm transition-all shadow-lg flex items-center gap-2
                            {{ Auth::user()->isFollowing($user) ? 'bg-slate-700 text-slate-300' : 'bg-brand-accent text-brand-dark hover:bg-brand-glow' }}">
                            <i
                                class="{{ Auth::user()->isFollowing($user) ? 'ph-bold ph-check' : 'ph-bold ph-user-plus' }}"></i>
                            <span
                                class="btn-text">{{ Auth::user()->isFollowing($user) ? 'Following' : 'Follow' }}</span>
                        </button>

                        {{-- Message Button --}}
                        <a href="{{ route('messages.show', $user->id) }}"
                            class="px-4 py-2 rounded-lg bg-slate-800 border border-slate-600 text-slate-300 hover:text-white hover:bg-slate-700 transition-colors flex items-center justify-center shadow-lg"
                            title="Send Message">
                            <i class="ph-bold ph-chat-circle-text text-lg"></i>
                        </a>

                        {{-- Block Menu --}}
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="px-3 py-2 h-full rounded-lg bg-slate-800 border border-slate-600 text-slate-400 hover:text-red-400 hover:border-red-500/50 transition-colors">
                                <i class="ph-bold ph-dots-three-vertical text-lg"></i>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 top-full mt-2 w-40 bg-slate-900 border border-slate-700 rounded-lg shadow-xl overflow-hidden z-20"
                                style="display: none;">
                                <button onclick="toggleBlockMember('{{ $user->id }}')"
                                    class="w-full text-left px-4 py-2 text-xs font-bold text-red-400 hover:bg-red-500/10 flex items-center gap-2">
                                    <i class="ph-bold ph-prohibit"></i> Block User
                                </button>
                            </div>
                        </div>
                    @else
                        {{-- Edit Profile Link --}}
                        <a href="{{ route('profile.edit') }}"
                            class="px-6 py-2 rounded-lg bg-slate-800 border border-slate-600 text-white font-bold text-sm hover:bg-slate-700 transition-colors">
                            Edit Profile
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- 2. TABS --}}
        <div class="border-b border-white/5 mb-8">
            <div class="flex items-center gap-8">
                <button @click="activeTab = 'snippets'"
                    :class="activeTab === 'snippets' ? 'border-brand-accent text-brand-accent' :
                        'border-transparent text-slate-400 hover:text-white'"
                    class="border-b-2 font-bold px-4 py-3 text-sm transition-colors relative">
                    Snippets
                    <span
                        class="bg-slate-800 px-1.5 py-0.5 rounded text-[10px] ml-1 opacity-70">{{ $user->snippets_count }}</span>
                </button>

                <button @click="activeTab = 'about'"
                    :class="activeTab === 'about' ? 'border-brand-accent text-brand-accent' :
                        'border-transparent text-slate-400 hover:text-white'"
                    class="border-b-2 font-bold px-4 py-3 text-sm transition-colors">
                    About
                </button>

                <button @click="activeTab = 'followers'"
                    :class="activeTab === 'followers' ? 'border-brand-accent text-brand-accent' :
                        'border-transparent text-slate-400 hover:text-white'"
                    class="border-b-2 font-bold px-4 py-3 text-sm transition-colors">
                    Followers
                    <span
                        class="bg-slate-800 px-1.5 py-0.5 rounded text-[10px] ml-1 opacity-70">{{ $user->followers_count }}</span>
                </button>
            </div>
        </div>

        {{-- 3. CONTENT AREAS --}}

        {{-- SNIPPETS TAB --}}
        <div x-show="activeTab === 'snippets'" x-transition.opacity>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($snippets as $snippet)
                    <a href="{{ route('snippets.show', $snippet->id) }}" class="group block h-full">
                        <div
                            class="bg-brand-card border border-white/5 rounded-xl p-5 h-full hover:border-brand-accent/50 hover:-translate-y-1 transition-all duration-300 flex flex-col relative overflow-hidden">
                            <div class="flex items-center justify-between mb-4">
                                <span
                                    class="bg-brand-accent/10 text-brand-accent text-[10px] font-bold px-2 py-0.5 rounded border border-brand-accent/20 uppercase">{{ $snippet->language }}</span>
                                <span class="text-slate-500 text-xs flex items-center gap-1"><i
                                        class="ph-fill ph-heart text-brand-accent"></i>
                                    {{ $snippet->likes_count }}</span>
                            </div>
                            <h3
                                class="text-lg font-bold text-white mb-2 group-hover:text-brand-glow transition-colors line-clamp-1">
                                {{ $snippet->title }}
                            </h3>
                            <div
                                class="bg-[#0d1117] rounded-lg p-3 mb-4 flex-1 border border-white/5 opacity-80 group-hover:opacity-100 transition-opacity">
                                <pre class="text-[10px] text-slate-400 font-mono line-clamp-4 leading-relaxed">{{ $snippet->code }}</pre>
                            </div>
                            <div
                                class="text-xs text-slate-500 mt-auto pt-3 border-t border-white/5 flex items-center gap-1">
                                <i class="ph ph-clock"></i> Posted {{ $snippet->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </a>
                @empty
                    <div
                        class="col-span-full py-20 text-center bg-brand-card/30 rounded-2xl border border-white/5 border-dashed">
                        <i class="ph-fill ph-code text-3xl text-slate-500 mb-4 inline-block"></i>
                        <h3 class="text-lg font-bold text-white">No snippets yet</h3>
                    </div>
                @endforelse
            </div>
            <div class="mt-8">{{ $snippets->links() }}</div>
        </div>

        {{-- ABOUT TAB --}}
        <div x-show="activeTab === 'about'" style="display: none;" x-transition.opacity>
            <div class="bg-brand-card border border-white/5 rounded-xl p-8 max-w-3xl">
                <h3 class="text-xl font-bold text-white mb-4">About {{ $user->name }}</h3>
                <div class="prose prose-invert max-w-none text-slate-300 mb-8">
                    @if ($user->bio)
                        <p>{{ $user->bio }}</p>
                    @else
                        <p class="italic text-slate-500">This user hasn't written a bio yet.</p>
                    @endif
                </div>
                <div class="grid grid-cols-2 gap-6 border-t border-white/5 pt-6">
                    <div>
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Member Since</h4>
                        <p class="text-white flex items-center gap-2">
                            <i class="ph-bold ph-calendar-check text-brand-accent"></i>
                            {{ $user->created_at->format('F j, Y') }}
                        </p>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total Contributions
                        </h4>
                        <p class="text-white flex items-center gap-2">
                            <i class="ph-bold ph-git-commit text-brand-accent"></i>
                            {{ $user->snippets_count + $user->comments_count }} Actions
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- FOLLOWERS TAB --}}
        <div x-show="activeTab === 'followers'" style="display: none;" x-transition.opacity>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($followers as $follower)
                    <div
                        class="bg-brand-card border border-white/5 rounded-xl p-4 flex items-center gap-4 hover:border-slate-600 transition-colors">
                        <a href="{{ route('profile.show', $follower->id) }}">
                            <img src="{{ $follower->avatar ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $follower->name }}"
                                class="w-12 h-12 rounded-full border border-slate-700">
                        </a>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('profile.show', $follower->id) }}"
                                class="block text-white font-bold hover:text-brand-accent truncate">
                                {{ $follower->name }}
                            </a>
                            <p class="text-xs text-slate-500">{{ $follower->followers_count }} Followers</p>
                        </div>
                        @if (Auth::id() !== $follower->id)
                            <button onclick="toggleFollowMember('{{ $follower->id }}', this)"
                                class="p-2 rounded-lg bg-slate-800 text-slate-400 hover:text-white hover:bg-slate-700 transition-colors"
                                title="Follow/Unfollow">
                                <i
                                    class="{{ Auth::user()->isFollowing($follower) ? 'ph-fill ph-check text-green-400' : 'ph-bold ph-user-plus' }}"></i>
                            </button>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center">
                        <p class="text-slate-500">No followers yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- SCRIPTS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
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

                    // If it's the large profile button
                    if (textSpan) {
                        if (res.status === 'followed') {
                            btn.className =
                                "px-6 py-2 rounded-lg font-bold text-sm transition-all shadow-lg flex items-center gap-2 bg-slate-700 text-slate-300";
                            textSpan.innerText = "Following";
                            icon.className = "ph-bold ph-check";
                        } else {
                            btn.className =
                                "px-6 py-2 rounded-lg font-bold text-sm transition-all shadow-lg flex items-center gap-2 bg-brand-accent text-brand-dark hover:bg-brand-glow";
                            textSpan.innerText = "Follow";
                            icon.className = "ph-bold ph-user-plus";
                        }
                    } else {
                        // If it's the small icon button in the list
                        if (res.status === 'followed') {
                            icon.className = "ph-fill ph-check text-green-400";
                        } else {
                            icon.className = "ph-bold ph-user-plus";
                        }
                    }
                }
            });
        }

        function toggleBlockMember(userId) {
            if (!confirm('Block this user?')) return;
            $.ajax({
                url: `/users/${userId}/block`,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function() {
                    window.location.href = "{{ route('home') }}";
                }
            });
        }
    </script>

</x-app-layout>
