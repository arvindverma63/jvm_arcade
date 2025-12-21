    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <style>
        /* --- FONT & LAYOUT --- */
        .mono-font {
            font-family: 'JetBrains Mono', 'Fira Code', 'Consolas', monospace;
            font-size: 14px;
            line-height: 1.5;
        }

        /* --- SYNTAX HIGHLIGHTING COLORS --- */
        .token-keyword {
            color: #f472b6;
            font-weight: bold;
        }

        /* Pink */
        .token-type {
            color: #60a5fa;
        }

        /* Blue */
        .token-string {
            color: #4ade80;
        }

        /* Green */
        .token-comment {
            color: #64748b;
            font-style: italic;
        }

        /* Slate */
        .token-number {
            color: #a78bfa;
        }

        /* Purple */

        /* --- CUSTOM SCROLLBAR --- */
        .custom-scrollbar::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #0f172a;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }

        /* --- QUILL EDITOR DARK MODE --- */
        .ql-toolbar.ql-snow {
            background-color: #0f172a;
            border-color: #334155 !important;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        .ql-container.ql-snow {
            background-color: #0f172a80;
            border-color: #334155 !important;
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
            color: #e2e8f0;
            font-size: 16px;
            font-family: sans-serif;
        }

        /* Quill Icons Fix */
        .ql-snow .ql-stroke {
            stroke: #94a3b8;
        }

        .ql-snow .ql-fill,
        .ql-snow .ql-stroke.ql-fill {
            fill: #94a3b8;
        }

        .ql-snow .ql-picker {
            color: #94a3b8;
        }

        .ql-snow .ql-picker-label:hover,
        .ql-snow .ql-picker-item:hover {
            color: #fff;
        }

        .ql-snow button:hover .ql-stroke {
            stroke: #fff;
        }
    </style>
