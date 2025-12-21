<x-app-layout title="My Profile - JVM Arcade" :right-sidebar="false">
    @include('components.profile-header')

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <div class="lg:col-span-1 space-y-6">
            @include('components.profile-sidebar')
        </div>

        <div class="lg:col-span-3">
            <div class="bg-brand-card rounded-xl border border-white/5 overflow-hidden">
                <div class="border-b border-slate-700/50 p-6">
                    <h2 class="text-xl font-bold text-white">Account Settings</h2>
                    <p class="text-sm text-slate-400 mt-1">Manage your public profile and developer preferences.</p>
                </div>

                <form class="p-6 space-y-8">

                    <div class="space-y-4">
                        <h3
                            class="text-sm font-bold text-brand-accent uppercase tracking-wider mb-4 border-b border-slate-700/50 pb-2">
                            Public Info</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs text-slate-400 font-bold">Display Name</label>
                                <input type="text" value="JavaDev_88"
                                    class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-slate-200 focus:border-brand-accent focus:ring-1 focus:ring-brand-accent outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs text-slate-400 font-bold">Title</label>
                                <input type="text" value="Full Stack Wizard"
                                    class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-slate-200 focus:border-brand-accent focus:ring-1 focus:ring-brand-accent outline-none transition-all">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs text-slate-400 font-bold">Bio</label>
                            <textarea rows="3"
                                class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-slate-200 focus:border-brand-accent focus:ring-1 focus:ring-brand-accent outline-none transition-all resize-none">Building voxel engines in pure Java since 2012. Love LibGDX and Spring Boot.</textarea>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3
                            class="text-sm font-bold text-brand-accent uppercase tracking-wider mb-4 border-b border-slate-700/50 pb-2">
                            Developer Experience</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs text-slate-400 font-bold">Primary Language</label>
                                <select
                                    class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-slate-200 focus:border-brand-accent outline-none">
                                    <option>Java</option>
                                    <option>Kotlin</option>
                                    <option>Scala</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs text-slate-400 font-bold">Theme</label>
                                <select
                                    class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-slate-200 focus:border-brand-accent outline-none">
                                    <option>Dark (Default)</option>
                                    <option>Light (Burn my eyes)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button"
                            class="px-5 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:text-white transition-colors">Cancel</button>
                        <button type="submit"
                            class="px-6 py-2.5 rounded-lg text-sm font-bold bg-brand-accent text-brand-dark hover:bg-brand-glow shadow-lg shadow-brand-accent/20 transition-all">Save
                            Changes</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</x-app-layout>
