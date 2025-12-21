 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="csrf-token" content="{{ csrf_token() }}">

 <title>{{ $title ?? 'JVM Arcade - Java Game Dev Community' }}</title>

 <link
     href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap"
     rel="stylesheet">

 <script src="https://unpkg.com/@phosphor-icons/web"></script>

 <script src="https://cdn.tailwindcss.com"></script>
 <script>
     tailwind.config = {
         darkMode: 'class',
         theme: {
             extend: {
                 fontFamily: {
                     sans: ['Inter', 'sans-serif'],
                     mono: ['JetBrains Mono', 'monospace'],
                 },
                 colors: {
                     brand: {
                         dark: '#0f172a', // Slate 900
                         card: '#1e293b', // Slate 800
                         hover: '#334155', // Slate 700
                         accent: '#f59e0b', // Amber 500 (Java Orange)
                         glow: '#fbbf24', // Amber 400
                         success: '#10b981', // Emerald 500
                         java: '#ef4444', // Red for Java Logo accent
                     }
                 }
             }
         }
     }
 </script>
 <style type="text/tailwindcss">
     @layer utilities {
         .scrollbar-hide::-webkit-scrollbar {
             display: none;
         }

         .glass-effect {
             @apply bg-brand-card/80 backdrop-blur-md border border-white/5;
         }

         .code-preview {
             @apply font-mono text-sm bg-black/40 p-3 rounded-md text-gray-300 border-l-2 border-brand-accent mt-3;
         }

         .java-keyword {
             @apply text-brand-accent;
         }

         .java-type {
             @apply text-brand-glow;
         }

         .java-string {
             @apply text-green-400;
         }

         .java-comment {
             @apply text-slate-500 italic;
         }
     }
 </style>
