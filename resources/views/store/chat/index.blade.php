<x-store-layout title="Chat AI">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600&display=swap');

        :root {
            --brand: #f59e0b;
            --brand-dim: #fbbf2422;
            --surface: #0d1117;
            --surface-2: #161b22;
            --surface-3: #21262d;
            --border: #30363d;
            --border-hover: #484f58;
            --text-1: #e6edf3;
            --text-2: #8b949e;
            --text-3: #656d76;
            --user-bg: #1f2937;
            --ai-bg: #0d1117;
            --radius: 12px;
            --radius-sm: 8px;
        }

        * { box-sizing: border-box; }

        body, .chat-root {
            font-family: 'Be Vietnam Pro', sans-serif;
            background: var(--surface);
        }

        /* === LAYOUT === */
        .chat-root {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            max-width: 860px;
            margin: 0 auto;
            padding: 28px 24px 48px;
        }

        /* === HEADER === */
        .chat-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }
        .chat-header-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--brand-dim);
            border: 1px solid #f59e0b44;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .chat-header-icon svg { width: 18px; height: 18px; color: var(--brand); }
        .chat-header h1 {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-1);
            margin: 0;
            letter-spacing: -.01em;
        }
        .chat-header p {
            font-size: 12px;
            color: var(--text-3);
            margin: 2px 0 0;
        }

        /* === CHAT BOX === */
        .chat-box {
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* === MESSAGES === */
        #chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
            min-height: 300px;
            max-height: 440px;
            scroll-behavior: smooth;
        }
        #chat-messages::-webkit-scrollbar { width: 4px; }
        #chat-messages::-webkit-scrollbar-track { background: transparent; }
        #chat-messages::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }

        .msg-row { display: flex; align-items: flex-end; gap: 8px; }
        .msg-row.user { flex-direction: row-reverse; }

        .msg-avatar {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 600;
        }
        .msg-avatar.ai {
            background: var(--brand-dim);
            border: 1px solid #f59e0b33;
            color: var(--brand);
        }
        .msg-avatar.user {
            background: var(--surface-3);
            border: 1px solid var(--border);
            color: var(--text-2);
        }

        .msg-bubble {
            max-width: 78%;
            padding: 10px 14px;
            border-radius: var(--radius);
            font-size: 13.5px;
            line-height: 1.6;
            white-space: pre-wrap;
            word-break: break-word;
        }
        .msg-bubble.ai {
            background: var(--ai-bg);
            border: 1px solid var(--border);
            color: var(--text-1);
            border-bottom-left-radius: 4px;
        }
        .msg-bubble.user {
            background: var(--user-bg);
            border: 1px solid #374151;
            color: var(--text-1);
            border-bottom-right-radius: 4px;
        }

        .chat-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            min-height: 200px;
            text-align: center;
            gap: 16px;
        }
        .chat-empty-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: var(--brand-dim);
            border: 1px solid #f59e0b33;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .chat-empty-icon svg { width: 22px; height: 22px; color: var(--brand); }
        .chat-empty p {
            font-size: 13px;
            color: var(--text-3);
            margin: 0;
            line-height: 1.6;
        }
        .chips { display: flex; flex-wrap: wrap; gap: 6px; justify-content: center; }
        .chip {
            font-size: 12px;
            color: var(--text-2);
            background: var(--surface-3);
            border: 1px solid var(--border);
            padding: 5px 12px;
            border-radius: 20px;
            cursor: pointer;
            transition: all .15s;
        }
        .chip:hover { border-color: var(--brand); color: var(--brand); }

        /* === TYPING INDICATOR === */
        .typing-indicator { display: none; }
        .typing-indicator.active { display: flex; }
        .typing-dots { display: flex; gap: 4px; align-items: center; padding: 10px 14px; }
        .typing-dots span {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: var(--text-3);
            animation: bounce 1.2s infinite;
        }
        .typing-dots span:nth-child(2) { animation-delay: .2s; }
        .typing-dots span:nth-child(3) { animation-delay: .4s; }
        @keyframes bounce {
            0%, 80%, 100% { transform: translateY(0); opacity: .4; }
            40% { transform: translateY(-5px); opacity: 1; }
        }

        /* === INPUT AREA === */
        .chat-input-area {
            padding: 14px 16px;
            border-top: 1px solid var(--border);
            background: var(--surface-2);
        }
        .input-wrapper {
            display: flex;
            gap: 8px;
            align-items: flex-end;
            background: var(--surface-3);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 10px 12px 10px 16px;
            transition: border-color .15s;
        }
        .input-wrapper:focus-within { border-color: var(--brand); }
        #chat-input {
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            color: var(--text-1);
            font-family: 'Be Vietnam Pro', sans-serif;
            font-size: 13.5px;
            line-height: 1.5;
            resize: none;
            max-height: 120px;
            min-height: 20px;
        }
        #chat-input::placeholder { color: var(--text-3); }

        .send-btn {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--brand);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: opacity .15s, transform .1s;
        }
        .send-btn:hover { opacity: .85; }
        .send-btn:active { transform: scale(.94); }
        .send-btn:disabled { opacity: .4; cursor: default; }
        .send-btn svg { width: 15px; height: 15px; color: #111; }

        #chat-error {
            margin-top: 8px;
            font-size: 12px;
            color: #f87171;
            display: none;
            padding: 8px 12px;
            background: #7f1d1d22;
            border: 1px solid #7f1d1d55;
            border-radius: var(--radius-sm);
        }

        /* === SUGGESTIONS === */
        .suggestions-section { margin-top: 28px; }
        .suggestions-section h2 {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-2);
            margin: 0 0 12px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }
        #suggestions {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 12px;
        }
        .product-card {
            background: var(--surface-2);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            text-decoration: none;
            display: block;
            transition: border-color .15s, transform .15s;
        }
        .product-card:hover { border-color: var(--border-hover); transform: translateY(-2px); }
        .product-img {
            aspect-ratio: 1/1;
            background: var(--surface-3);
            overflow: hidden;
        }
        .product-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .product-body { padding: 12px 14px; }
        .product-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-1);
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .product-cat {
            font-size: 11px;
            color: var(--text-3);
            margin-top: 4px;
        }
        .product-price {
            font-size: 14px;
            font-weight: 600;
            color: var(--brand);
            margin-top: 8px;
        }
    </style>

    <div class="chat-root">
        {{-- Header --}}
        <div class="chat-header">
            <div class="chat-header-icon">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                </svg>
            </div>
            <div>
                <h1>Tư vấn AI</h1>
                <p>Tìm sản phẩm phù hợp nhanh chóng</p>
            </div>
        </div>

        {{-- Chat box --}}
        <div class="chat-box">
            <div id="chat-messages">
                @if($messages->isEmpty())
                    <div class="chat-empty" id="empty-state">
                        <div class="chat-empty-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                            </svg>
                        </div>
                        <p>Hỏi gì cũng được, mình tư vấn liền!</p>
                        <div class="chips">
                            <span class="chip" onclick="sendChip(this)">Giày đá bóng dưới 1 triệu</span>
                            <span class="chip" onclick="sendChip(this)">Áo đấu màu vàng size L</span>
                            <span class="chip" onclick="sendChip(this)">Giày sân cỏ nhân tạo</span>
                        </div>
                    </div>
                @else
                    @foreach($messages as $m)
                        <div class="msg-row {{ $m->role === 'user' ? 'user' : '' }}">
                            <div class="msg-avatar {{ $m->role === 'user' ? 'user' : 'ai' }}">
                                {{ $m->role === 'user' ? 'U' : 'AI' }}
                            </div>
                            <div class="msg-bubble {{ $m->role === 'user' ? 'user' : 'ai' }}">{{ $m->content }}</div>
                        </div>
                    @endforeach
                @endif

                {{-- Typing indicator --}}
                <div class="msg-row typing-indicator" id="typing">
                    <div class="msg-avatar ai">AI</div>
                    <div class="msg-bubble ai" style="padding: 0;">
                        <div class="typing-dots">
                            <span></span><span></span><span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chat-input-area">
                <div class="input-wrapper">
                    <textarea id="chat-input" rows="1" placeholder="Ví dụ: Mình cần giày dưới 1 triệu, dễ bám sân..."></textarea>
                    <button class="send-btn" id="send-btn" type="button">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.269 20.876L5.999 12zm0 0h7.5"/>
                        </svg>
                    </button>
                </div>
                <div id="chat-error"></div>
            </div>
        </div>

        {{-- Suggestions --}}
        <div class="suggestions-section" id="suggestions-section" style="{{ 'display:none' }}">
            <h2>Gợi ý sản phẩm</h2>
            <div id="suggestions"></div>
        </div>
    </div>

    <script>
    (function () {
        const messagesEl = document.getElementById('chat-messages');
        const inputEl    = document.getElementById('chat-input');
        const sendBtn    = document.getElementById('send-btn');
        const errorBox   = document.getElementById('chat-error');
        const suggestions= document.getElementById('suggestions');
        const sugSection = document.getElementById('suggestions-section');
        const typing     = document.getElementById('typing');
        const emptyState = document.getElementById('empty-state');

        function esc(str) {
            return (str || '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
        }

        function addMessage(role, content) {
            if (emptyState) emptyState.remove();
            const row = document.createElement('div');
            row.className = 'msg-row' + (role === 'user' ? ' user' : '');

            const avatar = document.createElement('div');
            avatar.className = 'msg-avatar ' + (role === 'user' ? 'user' : 'ai');
            avatar.textContent = role === 'user' ? 'U' : 'AI';

            const bubble = document.createElement('div');
            bubble.className = 'msg-bubble ' + (role === 'user' ? 'user' : 'ai');
            bubble.textContent = content;

            row.appendChild(avatar);
            row.appendChild(bubble);
            messagesEl.insertBefore(row, typing);
            messagesEl.scrollTop = messagesEl.scrollHeight;
        }

        function setTyping(show) {
            typing.classList.toggle('active', show);
            messagesEl.scrollTop = messagesEl.scrollHeight;
        }

        function renderSuggestions(items) {
            if (!items || !items.length) return;
            suggestions.innerHTML = '';
            items.forEach(p => {
                const card = document.createElement('a');
                card.href = p.url || '#';
                card.className = 'product-card';

                const imgWrap = document.createElement('div');
                imgWrap.className = 'product-img';
                if (p.image) imgWrap.innerHTML = `<img src="${esc(p.image)}" alt="${esc(p.name)}" loading="lazy">`;

                const body = document.createElement('div');
                body.className = 'product-body';
                body.innerHTML = `
                    <div class="product-name">${esc(p.name)}</div>
                    ${p.category ? `<div class="product-cat">${esc(p.category)}</div>` : ''}
                    <div class="product-price">${Number(p.price || 0).toLocaleString('vi-VN')}đ</div>
                `;

                card.appendChild(imgWrap);
                card.appendChild(body);
                suggestions.appendChild(card);
            });
            sugSection.style.display = 'block';
        }

        function showError(msg) {
            errorBox.textContent = msg;
            errorBox.style.display = 'block';
            setTimeout(() => { errorBox.style.display = 'none'; }, 5000);
        }

        async function submit(text) {
            text = (text || '').trim();
            if (!text) return;

            errorBox.style.display = 'none';
            addMessage('user', text);
            inputEl.value = '';
            autoResize();
            sendBtn.disabled = true;
            setTyping(true);

            try {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const res = await fetch(@json(route('ai-chat.message')), {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': token },
                    body: JSON.stringify({ message: text }),
                });
                const data = await res.json();
                if (!res.ok) throw new Error(data?.message || 'Không gửi được tin nhắn');
                addMessage('assistant', data.reply || '');
                renderSuggestions(data.suggestions || []);
            } catch (err) {
                showError(err.message || 'Có lỗi xảy ra.');
            } finally {
                setTyping(false);
                sendBtn.disabled = false;
                inputEl.focus();
            }
        }

        function autoResize() {
            inputEl.style.height = 'auto';
            inputEl.style.height = Math.min(inputEl.scrollHeight, 120) + 'px';
        }

        inputEl.addEventListener('input', autoResize);
        inputEl.addEventListener('keydown', e => {
            if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); submit(inputEl.value); }
        });
        sendBtn.addEventListener('click', () => submit(inputEl.value));

        window.sendChip = function(el) { submit(el.textContent); };
    })();
    </script>
</x-store-layout>