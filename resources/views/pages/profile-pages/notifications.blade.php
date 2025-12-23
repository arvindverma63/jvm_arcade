<x-app-layout title="Notifications - JVM Arcade" :right-sidebar="false">

    @include('components.profile-header')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <div class="lg:col-span-1 space-y-6">
            @include('components.profile-sidebar')
        </div>

        <div class="lg:col-span-3">
            <div class="bg-brand-card rounded-xl border border-white/5 overflow-hidden">

                {{-- Header --}}
                <div class="flex items-center justify-between p-4 border-b border-white/5">
                    <h2 class="text-lg font-bold text-white">Notifications</h2>

                    {{-- Mark All Read Button (Only shows if there are unread items) --}}
                    @if (Auth::user()->unreadNotifications->count() > 0)
                        <a href="{{ route('notifications.readAll') }}"
                            class="text-xs text-brand-accent hover:text-white transition-colors">
                            Mark all as read
                        </a>
                    @endif
                </div>

                <div class="divide-y divide-white/5">

                    @forelse ($notifications as $notification)
                        {{--
                            DYNAMIC ICON LOGIC
                            We check the message content to decide which icon/color to show.
                        --}}
                        @php
                            $msg = $notification->data['message'] ?? '';
                            $lowerMsg = strtolower($msg);

                            // Defaults
                            $icon = 'ph-bell';
                            $bgClass = 'bg-slate-700/50';
                            $textClass = 'text-slate-400';

                            if (str_contains($lowerMsg, 'liked')) {
                                $icon = 'ph-heart';
                                $bgClass = 'bg-red-500/20';
                                $textClass = 'text-red-400';
                            } elseif (str_contains($lowerMsg, 'following') || str_contains($lowerMsg, 'followed')) {
                                $icon = 'ph-user-plus';
                                $bgClass = 'bg-blue-500/20';
                                $textClass = 'text-blue-400';
                            } elseif (str_contains($lowerMsg, 'badge') || str_contains($lowerMsg, 'reputation')) {
                                $icon = 'ph-trophy';
                                $bgClass = 'bg-yellow-500/20';
                                $textClass = 'text-yellow-400';
                            } elseif (str_contains($lowerMsg, 'replied') || str_contains($lowerMsg, 'comment')) {
                                $icon = 'ph-chat-circle';
                                $bgClass = 'bg-green-500/20';
                                $textClass = 'text-green-400';
                            } elseif (str_contains($lowerMsg, 'published') || str_contains($lowerMsg, 'snippet')) {
                                $icon = 'ph-code';
                                $bgClass = 'bg-brand-accent/20';
                                $textClass = 'text-brand-accent';
                            }
                        @endphp

                        {{-- Notification Item --}}
                        <div
                            class="p-4 flex gap-4 group cursor-pointer transition-colors relative
                                    {{ $notification->read_at ? 'hover:bg-white/5 bg-transparent' : 'bg-brand-accent/5 hover:bg-brand-accent/10' }}">

                            {{-- Icon --}}
                            <div
                                class="w-10 h-10 rounded-full {{ $bgClass }} {{ $textClass }} flex items-center justify-center shrink-0">
                                <i class="ph-fill {{ $icon }} text-xl"></i>
                            </div>

                            {{-- Content --}}
                            <div class="flex-1">
                                <p
                                    class="text-sm {{ $notification->read_at ? 'text-slate-400' : 'text-slate-200 font-medium' }}">
                                    {!! $notification->data['message'] !!}
                                </p>
                                <p class="text-xs text-slate-500 mt-1">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                            </div>

                            {{-- Unread Dot Indicator --}}
                            @if (!$notification->read_at)
                                <div class="flex flex-col items-end gap-2 justify-center">
                                    <div class="w-2 h-2 rounded-full bg-brand-accent"></div>
                                </div>
                            @endif

                            {{-- Delete Button (Hidden, appears on hover) --}}
                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST"
                                class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-600 hover:text-red-400 transition-colors"
                                    title="Delete Notification">
                                    <i class="ph ph-trash"></i>
                                </button>
                            </form>
                        </div>
                    @empty
                        {{-- Empty State --}}
                        <div class="p-8 text-center flex flex-col items-center">
                            <div
                                class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mb-4 text-slate-500">
                                <i class="ph ph-bell-slash text-3xl"></i>
                            </div>
                            <h3 class="text-white font-bold mb-1">All caught up!</h3>
                            <p class="text-slate-400 text-sm">You have no new notifications.</p>
                        </div>
                    @endforelse

                </div>

                {{-- Pagination --}}
                @if ($notifications->hasPages())
                    <div class="p-4 border-t border-white/5">
                        {{ $notifications->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
