    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        $(document).ready(function() {
            /* ---------------------------------------------------------
               1. INITIALIZE QUILL EDITORS (Main & Replies)
               --------------------------------------------------------- */
            // Initialize the main comment form
            initQuill($('.comment-submission-form').first());

            /* ---------------------------------------------------------
               2. SYNTAX HIGHLIGHTING (Read-Only)
               --------------------------------------------------------- */
            const rawCode = $('#raw-code').val();
            const $display = $('#code-display');
            const $lineNumbers = $('#line-numbers');

            const keywords =
                /\b(public|private|protected|class|static|void|int|float|double|boolean|String|new|return|if|else|for|while|import|package|fun|val|var|try|catch|throw)\b/g;

            function highlight(text) {
                let html = text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
                const placeholders = {};
                let pCount = 0;

                function store(str) {
                    const k = `__TOKEN_${pCount++}__`;
                    placeholders[k] = str;
                    return k;
                }

                html = html.replace(/(".*?"|'.*?')/g, match => store(`<span class="token-string">${match}</span>`));
                html = html.replace(/(\/\/.*)/g, match => store(`<span class="token-comment">${match}</span>`));
                html = html.replace(keywords, match => `<span class="token-keyword">${match}</span>`);
                html = html.replace(/\b([A-Z][a-zA-Z0-9]*)\b/g, match =>
                    `<span class="token-type">${match}</span>`);
                html = html.replace(/\b\d+\b/g, match => `<span class="token-number">${match}</span>`);

                for (let key in placeholders) html = html.replace(key, placeholders[key]);
                return html;
            }

            if (rawCode) {
                $display.html(highlight(rawCode));
                const lines = rawCode.split('\n').length;
                let numHtml = '';
                for (let i = 1; i <= lines; i++) numHtml += `<div>${i}</div>`;
                $lineNumbers.html(numHtml);
            }
        });

        /* ---------------------------------------------------------
           3. HELPER FUNCTIONS (Global Scope)
           --------------------------------------------------------- */

        // Init Quill on a specific form container
        function initQuill($form) {
            var container = $form.find('.quill-editor')[0];

            // Define Toolbar
            var toolbarOptions = [
                ['bold', 'italic', 'code-block'],
                [{
                    'list': 'ordered'
                }, {
                    'list': 'bullet'
                }],
                ['link', 'image'],
                ['clean']
            ];

            var quill = new Quill(container, {
                theme: 'snow',
                placeholder: 'Write a comment...',
                modules: {
                    toolbar: toolbarOptions
                }
            });

            // On Submit, Copy content to hidden input
            $form.on('submit', function() {
                var html = quill.root.innerHTML;
                $form.find('.quill-hidden-input').val(html);
            });
        }

        // Toggle Reply Box
        window.toggleReply = function(commentId) {
            var $replyBox = $('#reply-box-' + commentId);
            if ($replyBox.hasClass('hidden')) {
                $replyBox.removeClass('hidden');
                // Init Quill if not already initialized
                if (!$replyBox.data('quill-init')) {
                    initQuill($replyBox.find('form'));
                    $replyBox.data('quill-init', true);
                }
            } else {
                $replyBox.addClass('hidden');
            }
        };

        // AJAX Like Toggle
        window.toggleLike = function(id, type, btn) {
            $.ajax({
                url: "{{ route('like.toggle') }}",
                method: "POST",
                data: {
                    id: id,
                    type: type,
                    _token: "{{ csrf_token() }}"
                },
                success: function(res) {
                    var icon = $(btn).find('i');
                    var text = $(btn).find('.like-text');

                    if (res.liked) {
                        $(btn).removeClass('bg-brand-accent text-brand-dark hover:bg-brand-glow')
                            .addClass('bg-red-500 text-white shadow-lg shadow-red-900/20');
                        icon.removeClass('ph-bold').addClass('ph-fill');
                        text.text('Liked');
                    } else {
                        $(btn).removeClass('bg-red-500 text-white shadow-lg shadow-red-900/20')
                            .addClass('bg-brand-accent text-brand-dark hover:bg-brand-glow');
                        icon.removeClass('ph-fill').addClass('ph-bold');
                        text.text('Like Snippet');
                    }
                    $('.like-count-display').text(res.count);
                },
                error: function(err) {
                    alert('Error liking snippet. Please log in.');
                }
            });
        };

        window.toggleEdit = function(commentId) {
            var $displayBody = $('#comment-body-' + commentId);
            var $editBox = $('#edit-box-' + commentId);

            if ($editBox.hasClass('hidden')) {
                // Switch to Edit Mode
                $displayBody.addClass('hidden');
                $editBox.removeClass('hidden');

                // Initialize Quill if not already done
                if (!$editBox.data('quill-init')) {
                    initQuill($editBox.find('form'));
                    $editBox.data('quill-init', true);
                }
            } else {
                // Cancel Edit Mode
                $editBox.addClass('hidden');
                $displayBody.removeClass('hidden');
            }
        };

        // Copy Code
        window.copyToClipboard = function() {
            const code = document.getElementById('raw-code').value;
            navigator.clipboard.writeText(code).then(() => {
                const btn = document.getElementById('copy-text');
                const original = btn.innerText;
                btn.innerText = "Copied!";
                setTimeout(() => btn.innerText = original, 2000);
            });
        };
    </script>
