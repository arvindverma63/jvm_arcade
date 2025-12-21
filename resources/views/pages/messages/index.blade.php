<x-app-layout title="Messages - JVM Arcade" :right-sidebar="false">

    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-white mb-6 flex items-center gap-3">
            <i class="ph-fill ph-chat-circle-dots text-brand-accent"></i> Messages
        </h1>

        <div class="bg-brand-card border border-white/5 rounded-xl overflow-hidden shadow-xl min-h-[500px]">
            @if($inbox->isEmpty())
                <div class="flex flex-col items-center justify-center h-96 text-center p-6">
                    <div class="w-20 h-20 bg-slate-800 rounded-full flex items-center justify-center mb-4">
                        <i class="ph-fill ph-paper-plane-tilt text-4xl text-slate-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">No messages yet</h3>
                    <p class="text-slate-400 max-w-sm mb-6">Start a conversation with other developers from their profile page.</p>
                    <a href="{{ route('members.index') }}" class="px-6 py-2 rounded-lg bg-brand-accent text-brand-dark font-bold hover:bg-brand-glow">
                        Find Members
                    </a>
                </div>
            @else
                <div class="divide-y divide-white/5">
                    @foreach($inbox as $chat)
                        <a href="{{ route('messages.show', $chat['user']->id) }}"
                           class="block p-4 hover:bg-white/5 transition-colors {{ $chat['unread_count'] > 0 ? 'bg-brand-accent/5' : '' }}">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <img src="{{ $chat['user']->avatar ?? 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $chat['user']->name }}"
                                         class="w-12 h-12 rounded-full border border-slate-600">
                                    @if($chat['unread_count'] > 0)
                                        <div class="absolute -top-1 -right-1 w-5 h-5 bg-brand-accent text-brand-dark text-xs font-bold rounded-full flex items-center justify-center border-2 border-[#0d1117]">
                                            {{ $chat['unread_count'] }}
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-0.5">
                                        <h4 class="font-bold text-white truncate">{{ $chat['user']->name }}</h4>
                                        <span class="text-xs text-slate-500 whitespace-nowrap">{{ $chat['last_message']->created_at->diffForHumans(null, true, true) }}</span>
                                    </div>
                                    <p class="text-sm truncate {{ $chat['unread_count'] > 0 ? 'text-slate-200 font-medium' : 'text-slate-500' }}">
                                        @if($chat['last_message']->sender_id === Auth::id())
                                            <span class="text-slate-600">You:</span>
                                        @endif
                                        {{ $chat['last_message']->body }}
                                    </p>
                                </div>

                                <i class="ph-bold ph-caret-right text-slate-600"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</x-app-layout>
