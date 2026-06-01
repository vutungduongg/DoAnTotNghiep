<x-store-layout title="Tra cứu đơn hàng - {{ config('app.name', 'VT Store') }}" :search-action="route('products.index')">
    <div class="max-w-6xl mx-auto px-4 py-10">
        <div class="max-w-xl mx-auto">
            <div class="text-center">
                <div class="mx-auto h-14 w-14 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-center">
                    <svg class="h-6 w-6 text-emerald-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <h1 class="mt-4 text-2xl font-extrabold tracking-tight">Tra cứu đơn hàng</h1>
                <p class="mt-2 text-sm text-slate-600">Nhập mã đơn và email để xem trạng thái đơn hàng</p>
            </div>

            <div class="mt-6 bg-white border border-slate-200 rounded-2xl p-6">
                <form method="POST" action="{{ route('orders.track') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold tracking-wide uppercase text-slate-600">Mã đơn hàng <span class="text-red-600">*</span></label>
                        <input
                            name="order_number"
                            value="{{ old('order_number') }}"
                            required
                            placeholder="ORD-YYYYMMDD-XXXXXXXX"
                            class="mt-2 w-full h-11 px-4 rounded-xl border border-slate-200 bg-white text-sm font-mono text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-600/15 focus:border-emerald-300"
                        />
                        <x-input-error :messages="$errors->get('order_number')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block text-xs font-semibold tracking-wide uppercase text-slate-600">Email đặt hàng <span class="text-red-600">*</span></label>
                        <input
                            type="email"
                            name="customer_email"
                            value="{{ old('customer_email') }}"
                            required
                            placeholder="email@example.com"
                            class="mt-2 w-full h-11 px-4 rounded-xl border border-slate-200 bg-white text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-600/15 focus:border-emerald-300"
                        />
                        <x-input-error :messages="$errors->get('customer_email')" class="mt-2" />
                    </div>

                    <button type="submit" class="w-full h-12 rounded-xl bg-emerald-600 text-white text-sm font-extrabold tracking-wide hover:bg-emerald-500">
                        Tra cứu đơn hàng
                    </button>
                </form>
            </div>

            <div class="mt-5 text-center text-sm text-slate-600">
                Chưa có đơn hàng?
                <a href="{{ route('products.index') }}" class="font-semibold text-emerald-700 hover:text-emerald-600">Mua sắm ngay</a>
            </div>
        </div>
    </div>

</x-store-layout>