<x-app-layout title="New Snippet - JVM Arcade" :right-sidebar="false">

    <div class="max-w-5xl mx-auto"> {{-- Increased max-width slightly since we have more room --}}

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                    <i class="ph-fill ph-code-block text-brand-accent"></i>
                    Create New Snippet
                </h1>
                <p class="text-slate-400 text-sm mt-1">Share your code, config, or helper functions.</p>
            </div>
            <button class="text-sm text-slate-500 hover:text-white transition-colors">
                Cancel
            </button>
        </div>

        <div class="bg-brand-card border border-white/5 rounded-xl overflow-hidden shadow-xl">

            <form action="#" method="POST" class="p-6 space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Title</label>
                        <input type="text" placeholder="e.g. Efficient Matrix Multiplication"
                            class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-slate-200 focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Language</label>
                        <div class="relative">
                            <select
                                class="w-full appearance-none bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-slate-200 focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all cursor-pointer">
                                <option>Java</option>
                                <option>Kotlin</option>
                                <option>Scala</option>
                                <option>Groovy</option>
                                <option>GLSL (Shader)</option>
                                <option>XML / JSON</option>
                            </select>
                            <i
                                class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none"></i>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Code</label>
                        <button type="button"
                            class="text-xs text-brand-accent hover:text-brand-glow flex items-center gap-1">
                            <i class="ph ph-magic-wand"></i> Auto-format
                        </button>
                    </div>

                    <div class="rounded-lg border border-slate-700 overflow-hidden bg-[#0d1117]">
                        <div class="flex items-center gap-2 bg-slate-800/50 border-b border-slate-700 px-4 py-2">
                            <div class="flex gap-1.5">
                                <div class="w-3 h-3 rounded-full bg-red-500/50"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500/50"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500/50"></div>
                            </div>
                            <span class="text-xs text-slate-500 font-mono ml-2">Snippet.java</span>
                        </div>

                        <div class="flex">
                            <div
                                class="hidden sm:flex flex-col items-end gap-[2px] py-3 px-2 bg-slate-800/20 text-slate-600 font-mono text-sm select-none border-r border-slate-800">
                                <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span><span>8</span><span>9</span>
                            </div>
                            <textarea rows="12"
                                class="w-full bg-transparent border-0 text-slate-300 font-mono text-sm p-3 focus:ring-0 placeholder-slate-600 resize-none leading-relaxed"
                                placeholder="// Paste your code here...&#10;public class Snippet {&#10;    public static void main(String[] args) {&#10;        System.out.println('Hello World');&#10;    }&#10;}"></textarea>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Description /
                        Context</label>
                    <textarea rows="3" placeholder="Explain how this code works or what problem it solves..."
                        class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-slate-200 focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all resize-y"></textarea>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tags</label>
                    <input type="text" placeholder="e.g. #rendering, #algorithm (comma separated)"
                        class="w-full bg-slate-900/50 border border-slate-700 rounded-lg py-2.5 px-4 text-slate-200 focus:outline-none focus:border-brand-accent focus:ring-1 focus:ring-brand-accent transition-all">
                    <p class="text-[10px] text-slate-500">Add up to 5 tags to help others find your snippet.</p>
                </div>

                <div class="border-t border-slate-700/50 pt-4 mt-2"></div>

                <div class="flex items-center justify-end gap-3">
                    <button type="button"
                        class="px-5 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:text-white hover:bg-white/5 transition-colors">
                        Save Draft
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-lg text-sm font-bold bg-brand-accent text-brand-dark hover:bg-brand-glow shadow-lg shadow-brand-accent/20 transition-all flex items-center gap-2">
                        <i class="ph-bold ph-paper-plane-right"></i>
                        Publish Snippet
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
