<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    $(document).ready(function() {
        // --- 1. QUILL EDITOR SETUP ---
        var toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            [{
                'header': [1, 2, 3, false]
            }],
            [{
                'color': []
            }, {
                'background': []
            }],
            ['link', 'image', 'video'],
            ['clean']
        ];

        var quill = new Quill('#quill-editor-container', {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow',
            placeholder: 'Explain how this code works...'
        });

        // Sync Quill to Hidden Input on Submit
        $('#create-snippet-form').on('submit', function() {
            var html = quill.root.innerHTML;
            $('#quill-content-input').val(html);
        });

        // --- 2. TAGS INPUT LOGIC (New) ---
        const $tagInput = $('#tag-typing-input');
        const $tagContainer = $('#tags-visual-container');
        const $hiddenTags = $('#hidden-tags-input');
        let tags = [];

        // Focus input when clicking container
        $tagContainer.on('click', function() {
            $tagInput.focus();
        });

        // Handle Typing
        $tagInput.on('keydown', function(e) {
            const val = $(this).val().trim();

            // Add Tag on Comma (188) or Enter (13)
            if (e.key === ',' || e.key === 'Enter') {
                e.preventDefault(); // Prevent form submit or literal comma

                if (val && !tags.includes(val)) {
                    addTag(val);
                }
                $(this).val(''); // Clear input
            }
            // Remove Last Tag on Backspace if input empty
            else if (e.key === 'Backspace' && val === '') {
                if (tags.length > 0) {
                    removeTag(tags.length - 1);
                }
            }
        });

        function addTag(text) {
            // Clean text (remove extra spaces, force lowercase if desired)
            text = text.replace(/,/g, '').trim();
            if (!text) return;

            tags.push(text);
            renderTags();
            updateHiddenInput();
        }

        function removeTag(index) {
            tags.splice(index, 1);
            renderTags();
            updateHiddenInput();
        }

        function renderTags() {
            // Remove existing pills (keep the input at the end)
            $tagContainer.find('.tag-pill').remove();

            // Create HTML for each tag
            tags.forEach((tag, index) => {
                const pill = `
                    <div class="tag-pill">
                        <span>#${tag}</span>
                        <i class="ph-bold ph-x" onclick="removeTag(${index})"></i>
                    </div>
                `;
                $tagInput.before(pill); // Insert before the typing input
            });

            // Expose function globally so onclick works (since this is inside document.ready)
            window.removeTag = removeTag;
        }

        function updateHiddenInput() {
            $hiddenTags.val(tags.join(','));
        }

        // --- 3. CODE EDITOR LOGIC (Preserved) ---
        const $input = $('#code-input');
        const $output = $('#code-output');
        const $layerBack = $('#syntax-highlight');
        const $lineNumbers = $('#line-numbers');
        const keywords =
            /\b(public|private|protected|class|static|void|int|float|double|boolean|String|new|return|if|else|for|while|import|package|fun|val|var)\b/g;

        function highlight(text) {
            let html = text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
            const placeholders = {};
            let pCount = 0;

            function store(str) {
                const key = `__TOKEN_${pCount++}__`;
                placeholders[key] = str;
                return key;
            }
            html = html.replace(/(".*?"|'.*?')/g, match => store(`<span class="token-string">${match}</span>`));
            html = html.replace(/(\/\/.*)/g, match => store(`<span class="token-comment">${match}</span>`));
            html = html.replace(keywords, match => `<span class="token-keyword">${match}</span>`);
            html = html.replace(/\b([A-Z][a-zA-Z0-9]*)\b/g, match =>
            `<span class="token-type">${match}</span>`);
            html = html.replace(/\b\d+\b/g, match => `<span class="token-number">${match}</span>`);
            for (let key in placeholders) {
                html = html.replace(key, placeholders[key]);
            }
            if (text[text.length - 1] === "\n") html += " ";
            return html;
        }

        function sync() {
            const text = $input.val();
            $output.html(highlight(text));
            const scrollTop = $input.scrollTop();
            $layerBack.scrollTop(scrollTop);
            $lineNumbers.scrollTop(scrollTop);
            $layerBack.scrollLeft($input.scrollLeft());
            const lines = text.split('\n').length;
            let numHtml = '';
            for (let i = 1; i <= lines; i++) numHtml += `<div>${i}</div>`;
            $lineNumbers.html(numHtml);
        }

        $input.on('input scroll', sync);

        $input.on('keydown', function(e) {
            const start = this.selectionStart;
            const end = this.selectionEnd;
            const val = $(this).val();
            const pairs = {
                '{': '}',
                '(': ')',
                '[': ']',
                '"': '"',
                "'": "'"
            };
            if (pairs[e.key]) {
                e.preventDefault();
                $(this).val(val.substring(0, start) + e.key + pairs[e.key] + val.substring(end));
                this.selectionStart = this.selectionEnd = start + 1;
                sync();
            } else if (e.key === 'Tab') {
                e.preventDefault();
                $(this).val(val.substring(0, start) + "    " + val.substring(end));
                this.selectionStart = this.selectionEnd = start + 4;
                sync();
            } else if (e.key === 'Enter') {
                const prev = val.substring(start - 1, start);
                const next = val.substring(start, start + 1);
                if (prev === '{' && next === '}') {
                    e.preventDefault();
                    $(this).val(val.substring(0, start) + "\n    \n" + val.substring(end));
                    this.selectionStart = this.selectionEnd = start + 5;
                    sync();
                }
            }
        });

        sync();
    });
</script>
