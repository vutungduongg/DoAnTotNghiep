{{-- AI Chat Widget (global) --}}
<section
    id="ai-chat-widget"
    class="fixed bottom-5 right-5 z-50 w-[360px] max-w-[calc(100vw-2.5rem)] rounded-2xl border border-slate-200 bg-white shadow-lg overflow-hidden"
    aria-label="VT AI Assistant"
>
    <header class="flex items-start justify-between gap-3 px-4 py-3 bg-slate-900 text-white">
        <div class="min-w-0">
            <div class="flex items-center gap-2">
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-600 text-white text-xs font-extrabold">
                    VT
                </span>
                <h2 class="text-sm font-extrabold tracking-wide truncate">VT AI Assistant</h2>
            </div>
            <div class="mt-0.5 flex items-center gap-2 text-xs text-slate-200">
                <span class="inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                <span>Đang trực tuyến</span>
            </div>
        </div>

        <button
            id="ai-chat-close"
            type="button"
            class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-white/70 hover:text-white hover:bg-white/10"
            aria-label="Đóng chat"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </header>

    <div class="flex flex-col h-[520px] max-h-[70vh]">
        <div id="ai-chat-messages" class="flex-1 overflow-y-auto px-4 py-3 space-y-3 bg-white">
            {{-- messages injected by JS --}}
        </div>

        <div class="px-4 pb-2 bg-white">
            <div class="flex flex-wrap gap-2" aria-label="Gợi ý nhanh">
                <button type="button" class="ai-chip inline-flex items-center h-7 px-3 rounded-full text-xs font-semibold border border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100">
                    Tư vấn chọn size
                </button>
                <button type="button" class="ai-chip inline-flex items-center h-7 px-3 rounded-full text-xs font-semibold border border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100">
                    Sản phẩm mới nhất
                </button>
                <button type="button" class="ai-chip inline-flex items-center h-7 px-3 rounded-full text-xs font-semibold border border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100">
                    Chính sách đổi trả
                </button>
            </div>
        </div>

        <div class="px-4 pb-4 bg-white">
            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2">
                <textarea
                    id="ai-chat-input"
                    rows="1"
                    placeholder="Nhập tin nhắn..."
                    class="flex-1 resize-none bg-transparent text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none max-h-24"
                ></textarea>

                <span class="inline-flex h-9 w-9 items-center justify-center text-slate-400" aria-hidden="true">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l9.546-9.546a3 3 0 114.243 4.243l-9.193 9.193a1.5 1.5 0 01-2.121-2.121l8.839-8.839" />
                    </svg>
                </span>

                <button
                    id="ai-chat-send"
                    type="button"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-600 text-white hover:bg-emerald-500 disabled:opacity-50"
                    aria-label="Gửi"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.269 20.876L5.999 12zm0 0h7.5" />
                    </svg>
                </button>
            </div>

            <p id="ai-chat-error" class="mt-2 hidden text-xs text-red-600"></p>
        </div>
    </div>
</section>

{{-- AI Chat Launcher (shown when widget is closed) --}}
<button
    id="ai-chat-launcher"
    type="button"
    class="fixed bottom-5 right-5 z-50 hidden h-12 w-12 items-center justify-center rounded-full bg-emerald-600 text-white shadow-lg hover:bg-emerald-500"
    aria-label="Mở VT AI Assistant"
    aria-controls="ai-chat-widget"
    aria-expanded="false"
>
    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12c0 4.556 4.03 8.25 9 8.25.981 0 1.927-.144 2.815-.411.9.334 2.14.625 3.685.661-.539-.624-.994-1.53-1.174-2.514A7.707 7.707 0 0021.75 12c0-4.556-4.03-8.25-9-8.25s-9 3.694-9 8.25z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 12h.008v.008H8.25V12zm3.75 0h.008v.008H12V12zm3.75 0h.008v.008h-.008V12z" />
    </svg>
</button>

@php
    $chatWidgetInitial = ($chatMessages ?? collect())
        ->map(function ($m) {
            return [
                'role' => (string) ($m->role ?? ''),
                'content' => (string) ($m->content ?? ''),
                'time' => optional($m->created_at ?? null)->format('H:i'),
            ];
        })
        ->values();
@endphp

<script>
    (function () {
        const widgetEl = document.getElementById('ai-chat-widget');
        const launcherEl = document.getElementById('ai-chat-launcher');
        const closeEl = document.getElementById('ai-chat-close');

        const messagesEl = document.getElementById('ai-chat-messages');
        const inputEl = document.getElementById('ai-chat-input');
        const sendBtn = document.getElementById('ai-chat-send');
        const errorEl = document.getElementById('ai-chat-error');
        const chips = Array.from(document.querySelectorAll('#ai-chat-widget .ai-chip'));

        if (!widgetEl || !launcherEl || !messagesEl || !inputEl || !sendBtn || !errorEl) return;

        const storageKey = 'vt_ai_chat_open';

        function setOpenState(isOpen) {
            try {
                localStorage.setItem(storageKey, isOpen ? '1' : '0');
            } catch (e) {}
        }

        function getOpenState() {
            try {
                return localStorage.getItem(storageKey) === '1';
            } catch (e) {
                return false;
            }
        }

        function hideWidget() {
            widgetEl.classList.add('hidden');
            widgetEl.setAttribute('aria-hidden', 'true');

            launcherEl.classList.remove('hidden');
            launcherEl.classList.add('inline-flex');
            launcherEl.setAttribute('aria-expanded', 'false');

            setOpenState(false);
        }

        function showWidget() {
            widgetEl.classList.remove('hidden');
            widgetEl.setAttribute('aria-hidden', 'false');

            launcherEl.classList.add('hidden');
            launcherEl.classList.remove('inline-flex');
            launcherEl.setAttribute('aria-expanded', 'true');

            setOpenState(true);

            if (inputEl) inputEl.focus();
            if (messagesEl) messagesEl.scrollTop = messagesEl.scrollHeight;
        }

        if (closeEl) closeEl.addEventListener('click', hideWidget);
        launcherEl.addEventListener('click', showWidget);

        const initial = @json($chatWidgetInitial);

        function nowTime() {
            try {
                return new Intl.DateTimeFormat('vi-VN', { hour: '2-digit', minute: '2-digit' }).format(new Date());
            } catch (e) {
                const d = new Date();
                return String(d.getHours()).padStart(2, '0') + ':' + String(d.getMinutes()).padStart(2, '0');
            }
        }

        function scrollToBottom() {
            messagesEl.scrollTop = messagesEl.scrollHeight;
        }

        function addMessage(role, content, time) {
            const row = document.createElement('div');
            row.className = role === 'user' ? 'flex justify-end' : 'flex justify-start';

            const wrap = document.createElement('div');
            wrap.className = 'max-w-[85%]';

            const bubbleRow = document.createElement('div');
            bubbleRow.className = 'flex items-end gap-2 ' + (role === 'user' ? 'justify-end' : 'justify-start');

            if (role !== 'user') {
                const avatar = document.createElement('div');
                avatar.className = 'shrink-0 inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-600 text-white text-[10px] font-extrabold';
                avatar.textContent = 'VT';
                bubbleRow.appendChild(avatar);
            }

            const bubble = document.createElement('div');
            bubble.className = role === 'user'
                ? 'rounded-2xl rounded-br-md bg-slate-900 text-white px-3 py-2 text-sm leading-relaxed'
                : 'rounded-2xl rounded-bl-md bg-white border border-slate-200 text-slate-900 px-3 py-2 text-sm leading-relaxed';
            bubble.textContent = content;
            bubbleRow.appendChild(bubble);

            wrap.appendChild(bubbleRow);

            const meta = document.createElement('div');
            meta.className = 'mt-1 text-[10px] text-slate-400 ' + (role === 'user' ? 'text-right' : 'pl-9');
            meta.textContent = time || '';
            wrap.appendChild(meta);

            row.appendChild(wrap);
            messagesEl.appendChild(row);
            scrollToBottom();
        }

        function showError(msg) {
            errorEl.textContent = msg;
            errorEl.classList.remove('hidden');
            setTimeout(() => errorEl.classList.add('hidden'), 5000);
        }

        function autoResize() {
            inputEl.style.height = 'auto';
            inputEl.style.height = Math.min(inputEl.scrollHeight, 96) + 'px';
        }

        async function submit(text) {
            text = (text || '').trim();
            if (!text) return;

            errorEl.classList.add('hidden');
            addMessage('user', text, nowTime());
            inputEl.value = '';
            autoResize();
            sendBtn.disabled = true;

            try {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const res = await fetch(@json(route('ai-chat.message')), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token || '',
                    },
                    body: JSON.stringify({ message: text }),
                });

                const data = await res.json().catch(() => ({}));
                if (!res.ok) throw new Error(data?.message || 'Không gửi được tin nhắn');
                addMessage('assistant', String(data.reply || ''), nowTime());
            } catch (err) {
                showError(err?.message || 'Có lỗi xảy ra.');
            } finally {
                sendBtn.disabled = false;
                inputEl.focus();
            }
        }

        // Initial render
        if (Array.isArray(initial) && initial.length) {
            initial.forEach(m => addMessage(m.role === 'user' ? 'user' : 'assistant', String(m.content || ''), String(m.time || '')));
        } else {
            addMessage('assistant', 'Chào mừng bạn đến với VT Store! Tôi có thể giúp gì cho bạn hôm nay?', nowTime());
        }

        // Restore open/closed state across pages
        if (getOpenState()) {
            showWidget();
        } else {
            hideWidget();
        }

        // Events
        chips.forEach(btn => btn.addEventListener('click', () => submit(btn.textContent)));
        inputEl.addEventListener('input', autoResize);
        inputEl.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                submit(inputEl.value);
            }
        });
        sendBtn.addEventListener('click', () => submit(inputEl.value));

        autoResize();
        scrollToBottom();
    })();
</script>
