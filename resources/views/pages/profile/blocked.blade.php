<x-app-layout title="User Blocked" :right-sidebar="false">
    <div class="min-h-[60vh] flex flex-col items-center justify-center text-center">
        <div class="w-20 h-20 bg-red-500/10 rounded-full flex items-center justify-center mb-6">
            <i class="ph-fill ph-prohibit text-4xl text-red-500"></i>
        </div>
        <h1 class="text-3xl font-bold text-white mb-2">You have blocked {{ $user->name }}</h1>
        <p class="text-slate-400 max-w-md mb-8">
            You cannot see their snippets, comments, or activity while they are blocked.
        </p>

        <form action="{{ route('users.block', $user->id) }}" method="POST">
            @csrf
            <button
                class="px-6 py-3 rounded-lg bg-slate-800 text-white font-bold hover:bg-red-500 hover:text-white transition-colors border border-slate-700">
                Unblock User
            </button>
        </form>
    </div>
</x-app-layout>
