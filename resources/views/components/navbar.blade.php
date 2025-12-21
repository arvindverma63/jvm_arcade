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

        <div class="hidden md:flex flex-1 max-w-lg relative" id="search-container">
            <form action="{{ route('search') }}" method="GET" class="w-full">
                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-500"></i>
                <input type="text" name="q" id="search-input" autocomplete="off"
                    placeholder="Search LibGDX docs, Maven repos, or threads..."
                    class="w-full bg-slate-900/50 border border-slate-700 text-sm rounded-full py-2 pl-10 pr-4 focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all placeholder-slate-500 text-slate-200">
            </form>
            <div id="search-dropdown"
                class="hidden absolute top-full left-0 w-full mt-2 bg-[#0f172a] border border-slate-700 rounded-xl shadow-2xl overflow-hidden z-50">
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button class="md:hidden text-slate-400 hover:text-white">
                <i class="ph ph-magnifying-glass text-xl"></i>
            </button>
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

            <div class="relative group">
                <a href="{{ route('profile.show', Auth::id()) }}"
                    class="block w-9 h-9 rounded-full bg-slate-700 border border-slate-600 overflow-hidden cursor-pointer hover:ring-2 hover:ring-brand-accent transition-all">
                    <img src="{{ Auth::user()->avatar ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . Auth::user()->name }}"
                        class="w-full h-full object-cover">
                </a>

                <div
                    class="absolute right-0 top-full mt-2 w-48 bg-[#0f172a] border border-slate-700 rounded-xl shadow-2xl overflow-hidden opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 transform origin-top-right">
                    <div class="px-4 py-3 border-b border-white/5 bg-slate-800/50">
                        <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                    </div>

                    <div class="py-1">
                        <a href="{{ route('profile.show', Auth::id()) }}"
                            class="block px-4 py-2 text-sm text-slate-300 hover:bg-brand-accent/10 hover:text-brand-accent transition-colors">
                            Profile Overview
                        </a>
                        <a href="{{ route('profile.update') }}"
                            class="block px-4 py-2 text-sm text-slate-300 hover:bg-brand-accent/10 hover:text-brand-accent transition-colors">
                            Settings
                        </a>
                    </div>

                    <div class="border-t border-white/5 py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        let timeout = null;
        const $input = $('#search-input');
        const $dropdown = $('#search-dropdown');

        // Close dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('#search-container').length) {
                $dropdown.addClass('hidden');
            }
        });

        $input.on('input', function() {
            clearTimeout(timeout);
            const query = $(this).val();

            if (query.length < 2) {
                $dropdown.addClass('hidden').html('');
                return;
            }

            // Debounce to prevent too many requests (300ms delay)
            timeout = setTimeout(function() {
                $.ajax({
                    url: "{{ route('search.suggestions') }}",
                    data: {
                        q: query
                    },
                    success: function(res) {
                        let html = '';

                        // 1. Users Section
                        if (res.users.length > 0) {
                            html +=
                                `<div class="p-2">
                                        <h3 class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Members</h3>`;
                            res.users.forEach(user => {
                                let avatar = user.avatar ||
                                    `https://api.dicebear.com/7.x/avataaars/svg?seed=${user.name}`;
                                html += `<a href="/u/${user.id}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-800 transition-colors group">
                                            <img src="${avatar}" class="w-8 h-8 rounded-full border border-slate-700 group-hover:border-brand-accent">
                                            <span class="text-sm font-bold text-slate-200 group-hover:text-white">${user.name}</span>
                                        </a>`;
                            });
                            html += `</div>`;
                        }

                        // 2. Snippets Section
                        if (res.snippets.length > 0) {
                            if (res.users.length > 0) html +=
                                `<div class="border-t border-slate-700/50 my-1"></div>`;
                            html +=
                                `<div class="p-2">
                                        <h3 class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Snippets</h3>`;
                            res.snippets.forEach(snip => {
                                html += `<a href="/snippets/${snip.id}" class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-800 transition-colors group">
                                            <div class="flex items-center gap-2 overflow-hidden">
                                                <i class="ph-bold ph-code text-slate-500 group-hover:text-brand-accent"></i>
                                                <span class="text-sm text-slate-200 group-hover:text-white truncate">${snip.title}</span>
                                            </div>
                                            <span class="text-[10px] bg-slate-800 border border-slate-600 px-1.5 rounded text-slate-400">${snip.language}</span>
                                        </a>`;
                            });
                            html += `</div>`;
                        }

                        // 3. No Results
                        if (res.users.length === 0 && res.snippets.length === 0) {
                            html =
                                `<div class="p-4 text-center text-slate-500 text-sm">No results found for "${query}"</div>`;
                        } else {
                            html += `<a href="{{ route('search') }}?q=${query}" class="block bg-slate-800/50 p-3 text-center text-xs font-bold text-brand-accent hover:bg-slate-800 hover:text-white transition-colors border-t border-slate-700">
                                        View all results for "${query}"
                                     </a>`;
                        }

                        $dropdown.html(html).removeClass('hidden');
                    }
                });
            }, 300);
        });
    });
</script>
