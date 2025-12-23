<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header Section --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white">Notifications</h1>
                <p class="text-slate-400 text-sm mt-1">Stay updated with your latest activity.</p>
            </div>

            @if (auth()->user()->unreadNotifications->count() > 0)
                <a href="{{ route('notifications.readAll') }}"
                    class="inline-flex items-center px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm rounded-lg border border-slate-700 transition-colors">
                    <i class="ph ph-checks text-lg mr-2"></i>
                    Mark all as read
                </a>
            @endif
        </div>

        {{-- Notifications List --}}
        <div class="bg-[#0f172a] border border-slate-700 rounded-xl overflow-hidden shadow-sm">

            @forelse($notifications as $notification)
                <div
                    class="group relative flex items-start p-5 border-b border-slate-800 last:border-0 hover:bg-slate-800/30 transition-colors {{ $notification->read_at ? 'opacity-70' : '' }}">

                    {{-- Icon / Indicator --}}
                    <div class="flex-shrink-0 mr-4">
                        @if (!$notification->read_at)
                            <div class="w-2.5 h-2.5 rounded-full bg-brand-accent mt-2"></div>
                        @else
                            <div class="w-2.5 h-2.5 rounded-full bg-slate-600 mt-2"></div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white">
                            {{ $notification->data['message'] ?? 'Notification' }}
                        </p>
                        <p class="text-xs text-slate-500 mt-1">
                            {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="ml-4 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        @if (!$notification->read_at)
                            <a href="{{ route('notifications.markAsRead', $notification->id) }}"
                                class="p-1.5 text-slate-400 hover:text-white hover:bg-slate-700 rounded-lg"
                                title="Mark as read">
                                <i class="ph ph-check text-lg"></i>
                            </a>
                        @endif

                        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-1.5 text-slate-400 hover:text-red-400 hover:bg-red-500/10 rounded-lg"
                                title="Delete">
                                <i class="ph ph-trash text-lg"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-12 text-slate-500">
                    <i class="ph ph-bell-slash text-4xl mb-3 opacity-50"></i>
                    <p>No notifications yet.</p>
                </div>
            @endforelse

        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
</x-app-layout>
