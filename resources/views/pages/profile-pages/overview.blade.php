<x-app-layout title="Overview - JVM Arcade" :right-sidebar="false">

    @include('components.profile-header')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <div class="lg:col-span-1 space-y-6">
            @include('components.profile-sidebar')
        </div>

        <div class="lg:col-span-3 space-y-6">

            <div class="grid grid-cols-3 gap-4">
                <div class="bg-brand-card rounded-xl border border-white/5 p-4 text-center">
                    <div class="text-2xl font-bold text-brand-accent">{{ number_format($reputation) }}</div>
                    <div class="text-xs text-slate-500 uppercase font-bold tracking-wider">Reputation</div>
                </div>
                <div class="bg-brand-card rounded-xl border border-white/5 p-4 text-center">
                    <div class="text-2xl font-bold text-white">{{ $user->snippets_count }}</div>
                    <div class="text-xs text-slate-500 uppercase font-bold tracking-wider">Snippets</div>
                </div>
                <div class="bg-brand-card rounded-xl border border-white/5 p-4 text-center">
                    <div class="text-2xl font-bold text-white">{{ $user->followers_count }}</div>
                    <div class="text-xs text-slate-500 uppercase font-bold tracking-wider">Followers</div>
                </div>
            </div>

            <div class="bg-brand-card rounded-xl border border-white/5 p-6">
                <h3 class="text-sm font-bold text-white mb-4">Contribution Activity</h3>
                <div class="flex flex-wrap gap-1">
                    {{--
                        Real GitHub-style graphs require complex logic or a JS library.
                        For now, we generate a visual representation.
                        In production, pass real daily activity counts here.
                    --}}
                    @for ($i = 0; $i < 84; $i++)
                        @php
                            // Simulate activity: Randomly darker or lighter green
                            $rand = rand(0, 10);
                            $color = match (true) {
                                $rand > 8 => 'bg-brand-accent', // High activity
                                $rand > 5 => 'bg-green-600', // Medium
                                $rand > 2 => 'bg-green-900', // Low
                                default => 'bg-slate-800', // None
                            };
                        @endphp
                        <div class="w-3 h-3 rounded-sm {{ $color }}" title="Activity on day {{ $i }}">
                        </div>
                    @endfor
                </div>
                <div class="mt-2 text-xs text-slate-500">
                    {{ $user->snippets_count + $user->comments_count }} contributions in the last year
                </div>
            </div>

            <div class="bg-brand-card rounded-xl border border-white/5 p-0 overflow-hidden">
                <div class="p-4 border-b border-white/5">
                    <h3 class="text-sm font-bold text-white">Recent Activity</h3>
                </div>

                <div class="divide-y divide-white/5">
                    @forelse($activities as $activity)
                        <div class="p-4 flex gap-4 hover:bg-white/5 transition-colors">

                            {{-- Icon based on activity type --}}
                            <div class="mt-1">
                                @if ($activity->type === 'snippet_created')
                                    <i class="ph-fill ph-code text-brand-accent"></i>
                                @elseif($activity->type === 'commented')
                                    <i class="ph-fill ph-chat-circle text-blue-400"></i>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div>
                                @if ($activity->type === 'snippet_created')
                                    <p class="text-sm text-slate-300">
                                        Created a new snippet
                                        <a href="{{ route('snippets.show', $activity->id) }}"
                                            class="text-brand-accent hover:underline font-bold">
                                            {{ $activity->title }}
                                        </a>
                                    </p>
                                @elseif($activity->type === 'commented')
                                    <p class="text-sm text-slate-300">
                                        Commented on
                                        @if ($activity->commentable)
                                            <a href="{{ route('snippets.show', $activity->commentable->id) }}"
                                                class="text-white hover:underline font-bold">
                                                {{ $activity->commentable->title ?? 'a post' }}
                                            </a>
                                        @else
                                            <span class="text-slate-500">deleted content</span>
                                        @endif
                                    </p>
                                @endif

                                <span
                                    class="text-xs text-slate-500">{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-slate-500">
                            <p>No recent activity found.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
