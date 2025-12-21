<x-app-layout title="Settings - JVM Arcade" :right-sidebar="false">

    {{-- Assuming profile-header needs the user passed to it --}}
    @include('components.profile-header', ['user' => $user])

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <div class="lg:col-span-1 space-y-6">
            @include('components.profile-sidebar')
        </div>

        <div class="lg:col-span-3">

            {{-- Success Message --}}
            @if (session('success'))
                <div
                    class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl mb-6 flex items-center gap-2">
                    <i class="ph-bold ph-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-brand-card rounded-xl border border-white/5 overflow-hidden">
                <div class="border-b border-slate-700/50 p-6">
                    <h2 class="text-xl font-bold text-white">Account Settings</h2>
                    <p class="text-sm text-slate-400 mt-1">Manage your public profile and developer preferences.</p>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="p-6 space-y-8">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-4">
                        <h3
                            class="text-sm font-bold text-brand-accent uppercase tracking-wider mb-4 border-b border-slate-700/50 pb-2">
                            Public Info
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs text-slate-400 font-bold">Display Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-slate-200 focus:border-brand-accent focus:ring-1 focus:ring-brand-accent outline-none transition-all @error('name') border-red-500 @enderror">
                                @error('name')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs text-slate-400 font-bold">Title</label>
                                <input type="text" name="title" value="{{ old('title', $user->title) }}"
                                    placeholder="e.g. Full Stack Wizard"
                                    class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-slate-200 focus:border-brand-accent focus:ring-1 focus:ring-brand-accent outline-none transition-all">
                                @error('title')
                                    <span class="text-xs text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs text-slate-400 font-bold">Bio</label>
                            <textarea name="bio" rows="3"
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-slate-200 focus:border-brand-accent focus:ring-1 focus:ring-brand-accent outline-none transition-all resize-none">{{ old('bio', $user->bio) }}</textarea>
                            @error('bio')
                                <span class="text-xs text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3
                            class="text-sm font-bold text-brand-accent uppercase tracking-wider mb-4 border-b border-slate-700/50 pb-2">
                            Developer Experience
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs text-slate-400 font-bold">Primary Language</label>
                                <select name="primary_language"
                                    class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-slate-200 focus:border-brand-accent outline-none">
                                    @foreach (['Java', 'Kotlin', 'Scala', 'Groovy'] as $lang)
                                        <option value="{{ $lang }}"
                                            {{ old('primary_language', $user->primary_language) == $lang ? 'selected' : '' }}>
                                            {{ $lang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="text-xs text-slate-400 font-bold">Theme</label>
                                <select name="theme"
                                    class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-slate-200 focus:border-brand-accent outline-none">
                                    <option value="dark"
                                        {{ old('theme', $user->theme) == 'dark' ? 'selected' : '' }}>Dark (Default)
                                    </option>
                                    <option value="light"
                                        {{ old('theme', $user->theme) == 'light' ? 'selected' : '' }}>Light</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <a href="{{ route('profile.show', $user->id) }}"
                            class="px-5 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:text-white transition-colors">Cancel</a>
                        <button type="submit"
                            class="px-6 py-2.5 rounded-lg text-sm font-bold bg-brand-accent text-brand-dark hover:bg-brand-glow shadow-lg shadow-brand-accent/20 transition-all">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
