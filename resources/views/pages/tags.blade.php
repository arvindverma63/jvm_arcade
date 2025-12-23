<x-app-layout title="Explore Tags - JVM Arcade">

    {{-- HEADER & SEARCH --}}
    <div class="mb-8 text-center sm:text-left relative z-10">
        <h1 class="text-2xl font-bold text-white mb-2">Explore Topics</h1>
        <p class="text-slate-400 text-sm mb-6">Find libraries, frameworks, and discussions that interest you.</p>

        <form action="{{ route('tags') }}" method="GET" class="relative max-w-xl">
            <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-lg"></i>

            {{-- Search Input --}}
            <input type="text" name="q" id="tag-search-input" value="{{ request('q') }}"
                placeholder="Find a tag (e.g. java, kotlin, opengl)..." autocomplete="off"
                class="w-full bg-brand-card border border-white/10 rounded-xl py-3 pl-12 pr-4 text-slate-200 placeholder-slate-500 focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all shadow-lg">

            {{-- AJAX Suggestions Dropdown --}}
            <div id="search-suggestions"
                class="absolute left-0 w-full mt-2 bg-brand-card border border-white/10 rounded-xl shadow-2xl overflow-hidden hidden z-50">
                <ul id="suggestion-list" class="max-h-60 overflow-y-auto">
                    {{-- Results will be injected here via JS --}}
                </ul>
                {{-- Loading State --}}
                <div id="search-loading" class="hidden p-4 text-center text-slate-400 text-sm">
                    <i class="ph ph-spinner animate-spin mr-2"></i> Searching...
                </div>
            </div>
        </form>
    </div>
    {{-- TRENDING SECTION --}}
    @if (!$search && $trendingTags->count() > 0)
        <div class="mb-8">
            <h2 class="flex items-center gap-2 text-sm font-bold text-slate-300 uppercase tracking-wider mb-4">
                <i class="ph-fill ph-trend-up text-brand-accent"></i> Trending Now
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach ($trendingTags as $trend)
                    {{-- Dynamic Color Logic for Trending --}}
                    @php
                        $colors = ['red', 'blue', 'purple', 'emerald', 'orange'];
                        // Pick a color based on the loop index to alternate
                        $color = $colors[$loop->index % count($colors)];
                    @endphp

                    <a href="{{ route('home', ['filter' => 'questions', 'tag' => $trend->slug]) }}"
                        class="group relative bg-gradient-to-br from-{{ $color }}-900/40 to-brand-card border border-{{ $color }}-500/20 rounded-xl p-5 overflow-hidden hover:border-{{ $color }}-500/50 transition-all cursor-pointer block">

                        {{-- Decorative Icon Background --}}
                        <div
                            class="absolute -right-4 -bottom-4 text-{{ $color }}-500/10 group-hover:text-{{ $color }}-500/20 transition-colors">
                            <i class="ph-fill ph-hash text-9xl"></i>
                        </div>

                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-2">
                                <span
                                    class="text-xl font-bold text-white group-hover:text-{{ $color }}-400 transition-colors">
                                    #{{ $trend->name }}
                                </span>
                                <span
                                    class="bg-{{ $color }}-500/20 text-{{ $color }}-300 text-xs font-bold px-2 py-1 rounded">
                                    Hot
                                </span>
                            </div>
                            <p class="text-slate-400 text-sm mb-4">
                                Popular topic with {{ $trend->snippets_count }} recent snippets.
                            </p>
                            <div class="text-xs text-slate-500 font-mono">{{ $trend->snippets_count }} Posts total
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ALL CATEGORIES GRID --}}
    <div>
        <h2 class="flex items-center gap-2 text-sm font-bold text-slate-300 uppercase tracking-wider mb-4">
            <i class="ph-fill ph-hash text-brand-accent"></i>
            {{ $search ? 'Search Results' : 'All Categories' }}
        </h2>

        @if ($tags->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach ($tags as $tag)
                    {{--
                        COLOR GENERATOR
                        This assigns a consistent color based on the tag name's length/characters.
                        No DB column needed.
                    --}}
                    @php
                        $styles = [
                            ['text-green-400', 'bg-green-500/10', 'border-green-500/20'],
                            ['text-blue-400', 'bg-blue-500/10', 'border-blue-500/20'],
                            ['text-purple-400', 'bg-purple-500/10', 'border-purple-500/20'],
                            ['text-orange-400', 'bg-orange-500/10', 'border-orange-500/20'],
                            ['text-indigo-400', 'bg-indigo-500/10', 'border-indigo-500/20'],
                            ['text-pink-400', 'bg-pink-500/10', 'border-pink-500/20'],
                            ['text-emerald-400', 'bg-emerald-500/10', 'border-emerald-500/20'],
                            ['text-yellow-400', 'bg-yellow-500/10', 'border-yellow-500/20'],
                        ];
                        // Use crc32 to hash the name into an integer, then mod by style count
                        $styleIndex = crc32($tag->name) % count($styles);
                        [$textColor, $bgColor, $borderColor] = $styles[$styleIndex];
                    @endphp

                    {{-- Card --}}
                    {{-- Note: Update route to wherever you filter by tag --}}
                    <a href="{{ route('home', ['tag' => $tag->slug]) }}"
                        class="bg-brand-card rounded-lg border border-white/5 p-4 flex items-center justify-between hover:border-slate-500 transition-all group cursor-pointer">

                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-lg {{ $bgColor }} {{ $borderColor }} border flex items-center justify-center">
                                <span class="text-lg font-bold {{ $textColor }}">#</span>
                            </div>
                            <div>
                                <h3 class="text-slate-200 font-bold text-sm group-hover:text-white transition-colors">
                                    {{ $tag->name }}
                                </h3>
                                <p class="text-xs text-slate-500">{{ $tag->snippets_count }} posts</p>
                            </div>
                        </div>

                        <span class="text-slate-600 group-hover:text-brand-accent transition-colors">
                            <i class="ph-bold ph-caret-right text-lg"></i>
                        </span>
                    </a>
                @endforeach
            </div>

            {{-- PAGINATION --}}
            <div class="mt-8">
                {{ $tags->appends(['q' => $search])->links() }}
            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-12 border border-dashed border-slate-700 rounded-xl">
                <div
                    class="w-12 h-12 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-500">
                    <i class="ph ph-magnifying-glass text-xl"></i>
                </div>
                <h3 class="text-white font-bold mb-1">No tags found</h3>
                <p class="text-slate-400 text-sm">Try searching for something else.</p>
            </div>
        @endif
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('tag-search-input');
            const suggestionsBox = document.getElementById('search-suggestions');
            const suggestionList = document.getElementById('suggestion-list');
            const loadingIndicator = document.getElementById('search-loading');

            let debounceTimer;

            // 1. Listen for typing
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();

                // Clear previous timeout
                clearTimeout(debounceTimer);

                // Hide box if empty
                if (query.length < 2) {
                    suggestionsBox.classList.add('hidden');
                    return;
                }

                // Show loading, clear previous results
                suggestionsBox.classList.remove('hidden');
                loadingIndicator.classList.remove('hidden');
                suggestionList.innerHTML = '';

                // 2. Debounce & Fetch (Wait 300ms after user stops typing)
                debounceTimer = setTimeout(() => {
                    fetchSuggestions(query);
                }, 300);
            });

            // 3. Fetch Logic
            function fetchSuggestions(query) {
                // Replace with your actual route URL
                fetch(`/api/tags/search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        loadingIndicator.classList.add('hidden');
                        suggestionList.innerHTML = '';

                        if (data.length === 0) {
                            suggestionList.innerHTML = `
                            <li class="px-4 py-3 text-sm text-slate-500">No results found.</li>
                        `;
                        } else {
                            data.forEach(item => {
                                const li = document.createElement('li');
                                // Customize the output HTML below
                                li.innerHTML = `
                                <a href="/tags?q=${item.name}" class="block px-4 py-3 text-sm text-slate-300 hover:bg-white/5 hover:text-white transition-colors border-b border-white/5 last:border-0 cursor-pointer">
                                    <span class="font-semibold text-brand-accent">#</span> ${item.name}
                                </a>
                            `;
                                suggestionList.appendChild(li);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        loadingIndicator.classList.add('hidden');
                    });
            }

            // 4. Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                    suggestionsBox.classList.add('hidden');
                }
            });
        });
    </script>

</x-app-layout>
