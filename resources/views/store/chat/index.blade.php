<x-store-layout title="Chat AI" :showChatWidget="false">
    <div class="mx-auto max-w-5xl px-6 py-8">
        <header class="flex items-start gap-3">
            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white text-xs font-extrabold">
                VT
            </span>

            <div class="min-w-0">
                <h1 class="text-lg sm:text-xl font-extrabold tracking-tight text-white">Tư vấn AI</h1>
                <p class="mt-1 text-sm text-slate-300">Hỏi nhanh – gợi ý sản phẩm phù hợp theo nhu cầu của bạn.</p>
            </div>
        </header>

        <section class="mt-6 rounded-2xl border border-slate-200 bg-white shadow-lg overflow-hidden">
            <div class="flex flex-col h-[560px] max-h-[70vh]">
                <div id="chat-messages" class="flex-1 overflow-y-auto px-4 py-4 space-y-3 bg-white">
                    @if($messages->isEmpty())
                        <div id="empty-state" class="h-full min-h-[240px] flex flex-col items-center justify-center text-center gap-4">
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12c0 4.556 4.03 8.25 9 8.25.981 0 1.927-.144 2.815-.411.9.334 2.14.625 3.685.661-.539-.624-.994-1.53-1.174-2.514A7.707 7.707 0 0021.75 12c0-4.556-4.03-8.25-9-8.25s-9 3.694-9 8.25z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 12h.008v.008H8.25V12zm3.75 0h.008v.008H12V12zm3.75 0h.008v.008h-.008V12z" />
                                </svg>
                            </div>

                            <div class="space-y-1">
                                <p class="text-sm font-semibold text-slate-900">Hỏi gì cũng được, mình tư vấn liền!</p>
                                <p class="text-xs text-slate-500">Gợi ý nhanh: chọn một câu bên dưới để bắt đầu.</p>
                            </div>

                            <div class="flex flex-wrap gap-2 justify-center" aria-label="Gợi ý nhanh">
                                <button type="button" class="inline-flex items-center h-8 px-3 rounded-full text-xs font-semibold border border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100" onclick="sendChip(this)">
                                    Giày đá bóng dưới 1 triệu
                                </button>
                                <button type="button" class="inline-flex items-center h-8 px-3 rounded-full text-xs font-semibold border border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100" onclick="sendChip(this)">
                                    Áo đấu màu vàng size L
                                </button>
                                <button type="button" class="inline-flex items-center h-8 px-3 rounded-full text-xs font-semibold border border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100" onclick="sendChip(this)">
                                    Giày sân cỏ nhân tạo
                                </button>
                            </div>
                        </div>
                    @else
                        @foreach($messages as $m)
                            @if ($m->role === 'user')
                                <div class="flex justify-end">
                                    <div class="max-w-[85%]">
                                        <div class="flex items-end justify-end">
                                            <div class="rounded-2xl rounded-br-md bg-slate-900 text-white px-3 py-2 text-sm leading-relaxed whitespace-pre-wrap break-words">{{ $m->content }}</div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="flex justify-start">
                                    <div class="max-w-[85%]">
                                        <div class="flex items-end gap-2 justify-start">
                                            <div class="shrink-0 inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-600 text-white text-[10px] font-extrabold">VT</div>
                                            <div class="rounded-2xl rounded-bl-md bg-white border border-slate-200 text-slate-900 px-3 py-2 text-sm leading-relaxed whitespace-pre-wrap break-words">{{ $m->content }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif

                    <div id="typing" class="hidden flex justify-start">
                        <div class="max-w-[85%]">
                            <div class="flex items-end gap-2 justify-start">
                                <div class="shrink-0 inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-600 text-white text-[10px] font-extrabold">VT</div>
                                <div class="rounded-2xl rounded-bl-md bg-white border border-slate-200 text-slate-900 px-3 py-2">
                                    <div class="flex items-center gap-1">
                                        <span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-400 animate-bounce"></span>
                                        <span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay:120ms"></span>
                                        <span class="inline-block h-1.5 w-1.5 rounded-full bg-slate-400 animate-bounce" style="animation-delay:240ms"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-4 pb-4 bg-white">
                    <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2">
                        <textarea
                            id="chat-input"
                            rows="1"
                            placeholder="Ví dụ: Mình cần giày dưới 1 triệu, dễ bám sân..."
                            class="flex-1 resize-none bg-transparent text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none max-h-28"
                        ></textarea>

                        <button
                            id="send-btn"
                            type="button"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-600 text-white hover:bg-emerald-500 disabled:opacity-50"
                            aria-label="Gửi"
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.269 20.876L5.999 12zm0 0h7.5"/>
                            </svg>
                        </button>
                    </div>

                    <p id="chat-error" class="mt-2 hidden text-xs text-red-600"></p>
                </div>
            </div>
        </section>

        <section id="suggestions-section" class="mt-8 hidden">
            <h2 class="text-xs font-extrabold tracking-wide uppercase text-slate-200">Gợi ý sản phẩm</h2>
            <div id="suggestions" class="mt-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"></div>
        </section>
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

            if (role === 'user') {
                row.className = 'flex justify-end';
                row.innerHTML = `
                    <div class="max-w-[85%]">
                        <div class="flex items-end justify-end">
                            <div class="rounded-2xl rounded-br-md bg-slate-900 text-white px-3 py-2 text-sm leading-relaxed whitespace-pre-wrap break-words"></div>
                        </div>
                    </div>
                `;
                row.querySelector('div.rounded-2xl').textContent = content;
            } else {
                row.className = 'flex justify-start';
                row.innerHTML = `
                    <div class="max-w-[85%]">
                        <div class="flex items-end gap-2 justify-start">
                            <div class="shrink-0 inline-flex h-7 w-7 items-center justify-center rounded-full bg-emerald-600 text-white text-[10px] font-extrabold">VT</div>
                            <div class="rounded-2xl rounded-bl-md bg-white border border-slate-200 text-slate-900 px-3 py-2 text-sm leading-relaxed whitespace-pre-wrap break-words"></div>
                        </div>
                    </div>
                `;
                row.querySelector('div.rounded-2xl').textContent = content;
            }

            messagesEl.insertBefore(row, typing);
            messagesEl.scrollTop = messagesEl.scrollHeight;
        }

        function setTyping(show) {
            typing.classList.toggle('hidden', !show);
            messagesEl.scrollTop = messagesEl.scrollHeight;
        }

        function renderSuggestions(items) {
            if (!items || !items.length) return;
            suggestions.innerHTML = '';
            items.forEach(p => {
                const card = document.createElement('a');
                card.href = p.url || '#';
                card.className = 'group block rounded-2xl border border-slate-200 bg-white overflow-hidden hover:border-slate-300 transition';

                const imgWrap = document.createElement('div');
                imgWrap.className = 'aspect-square bg-slate-50 overflow-hidden';
                if (p.image) imgWrap.innerHTML = `<img src="${esc(p.image)}" alt="${esc(p.name)}" loading="lazy" class="h-full w-full object-contain p-4 transition-transform group-hover:scale-[1.02]">`;
                else imgWrap.innerHTML = `<div class="h-full w-full flex items-center justify-center text-slate-300">Không có ảnh</div>`;

                const body = document.createElement('div');
                body.className = 'p-4';
                body.innerHTML = `
                    <div class="text-sm font-bold text-slate-900 leading-snug line-clamp-2">${esc(p.name)}</div>
                    ${p.category ? `<div class="mt-1 text-xs text-slate-500">${esc(p.category)}</div>` : ''}
                    <div class="mt-2 text-base font-extrabold text-amber-600">${Number(p.price || 0).toLocaleString('vi-VN')}đ</div>
                `;

                card.appendChild(imgWrap);
                card.appendChild(body);
                suggestions.appendChild(card);
            });
            sugSection.classList.remove('hidden');
        }

        function showError(msg) {
            errorBox.textContent = msg;
            errorBox.classList.remove('hidden');
            setTimeout(() => { errorBox.classList.add('hidden'); }, 5000);
        }

        async function submit(text) {
            text = (text || '').trim();
            if (!text) return;

            errorBox.classList.add('hidden');
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