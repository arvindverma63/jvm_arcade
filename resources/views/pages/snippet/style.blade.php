    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <style>
        /* FONT SETUP: Critical for alignment */
        .mono-font {
            font-family: 'JetBrains Mono', 'Fira Code', 'Consolas', monospace;
            font-size: 14px;
            line-height: 1.5;
            letter-spacing: normal;
        }

        /* CODE EDITOR STYLES */
        .editor-wrapper {
            position: relative;
            height: 320px;
            width: 100%;
            background-color: #0d1117;
            border-radius: 0 0 0.5rem 0.5rem;
            overflow: hidden;
        }

        .editor-layer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 12px;
            margin: 0;
            border: none;
            box-sizing: border-box;
            white-space: pre;
            overflow-wrap: normal;
            overflow: auto;
            tab-size: 4;
        }

        .syntax-layer {
            z-index: 1;
            color: #cbd5e1;
            background-color: transparent;
            pointer-events: none;
        }

        .syntax-layer::-webkit-scrollbar {
            display: none;
        }

        .syntax-layer {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .input-layer {
            z-index: 2;
            background: transparent !important;
            background-color: transparent !important;
            color: transparent !important;
            caret-color: #fbbf24;
            appearance: none;
            -webkit-appearance: none;
            outline: none;
            resize: none;
            box-shadow: none !important;
            border-radius: 0;
            -webkit-text-fill-color: transparent;
        }

        /* SYNTAX COLORS */
        .token-keyword {
            color: #f472b6;
            font-weight: bold;
        }

        .token-type {
            color: #60a5fa;
        }

        .token-string {
            color: #4ade80;
        }

        .token-comment {
            color: #64748b;
            font-style: italic;
        }

        .token-number {
            color: #a78bfa;
        }

        /* QUILL EDITOR DARK MODE OVERRIDES */
        .ql-toolbar.ql-snow {
            background-color: #0f172a;
            /* Slate 900 */
            border-color: #334155 !important;
            /* Slate 700 */
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
            /* Reset font for description */
            min-height: 150px;
        }

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
    <style>
        .tag-pill {
            display: inline-flex;
            align-items: center;
            background: rgba(251, 191, 36, 0.1);
            /* Brand Accent / 10% */
            border: 1px solid rgba(251, 191, 36, 0.2);
            color: #fbbf24;
            /* Brand Accent */
            border-radius: 9999px;
            padding: 0.125rem 0.625rem;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 0.25rem;
            margin-bottom: 0.25rem;
        }

        .tag-pill i {
            margin-left: 0.375rem;
            cursor: pointer;
            opacity: 0.7;
        }

        .tag-pill i:hover {
            opacity: 1;
            color: #fff;
        }

        /* The container looks like an input but holds pills + actual input */
        .tags-input-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            min-height: 46px;
            /* Match other inputs */
            cursor: text;
        }

        .tags-input-container input {
            flex: 1;
            min-width: 120px;
            border: none;
            background: transparent;
            outline: none;
            color: #e2e8f0;
            font-size: 0.875rem;
            /* text-sm */
            padding: 0;
            margin: 0;
        }

        .tags-input-container input:focus {
            ring: 0;
            outline: none;
            box-shadow: none;
        }
    </style>
