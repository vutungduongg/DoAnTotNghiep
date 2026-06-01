@php
    $firstInStockVariant = $product->variants->firstWhere('stock', '>', 0);
    $selectedVariantId = old('variant_id') ?? ($firstInStockVariant?->id ?? $product->variants->first()?->id);
    $selectedVariant = $selectedVariantId ? $product->variants->firstWhere('id', (int) $selectedVariantId) : null;
    if ($selectedVariant && (int) $selectedVariant->stock <= 0 && $firstInStockVariant) {
        $selectedVariantId = $firstInStockVariant->id;
        $selectedVariant = $firstInStockVariant;
    }
    $qty = (int) old('quantity', 1);
    $qty = max(1, min(99, $qty));
    $hasVariantPrices = $product->variants->whereNotNull('price')->count() > 0;
    $isAllVariantsOutOfStock = $product->variants->count() > 0 && $product->variants->where('stock', '>', 0)->count() === 0;
@endphp

<x-store-layout title="{{ $product->name }} - {{ config('app.name', 'VT Store') }}">

    @if (session('status'))
        <div class="max-w-6xl mx-auto px-4 mt-4">
            <div class="px-4 py-3 rounded-xl text-sm bg-emerald-50 border border-emerald-200 text-emerald-900">
                {{ session('status') }}
            </div>
        </div>
    @endif

    <div class="max-w-6xl mx-auto px-4 py-6">
        <nav class="text-xs text-slate-500">
            <a href="{{ route('home') }}" class="hover:text-slate-900">Trang chủ</a>
            <span class="mx-1">·</span>
            <a href="{{ route('products.index') }}" class="hover:text-slate-900">Sản phẩm</a>
            @if ($product->category)
                <span class="mx-1">·</span>
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-slate-900">{{ $product->category->name }}</a>
            @endif
            <span class="mx-1">·</span>
            <span class="text-slate-700">{{ $product->name }}</span>
        </nav>

        <section class="mt-5 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <div class="lg:col-span-7">
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                    <div class="aspect-square bg-slate-50 flex items-center justify-center">
                        @if ($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-contain p-6" />
                        @else
                            <div class="h-full w-full flex items-center justify-center text-slate-400">
                                <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M3 3h18v18H3V3z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                @if ($product->category)
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-xs font-semibold tracking-wide uppercase text-slate-500 hover:text-slate-900">
                        {{ $product->category->name }}
                    </a>
                @endif

                <div class="mt-2 flex items-start justify-between gap-3">
                    <h1 class="text-2xl md:text-3xl font-bold leading-tight text-slate-900">{{ $product->name }}</h1>
                    @if ($isAllVariantsOutOfStock)
                        <span class="shrink-0 inline-flex items-center h-7 px-3 rounded-full bg-rose-50 border border-rose-200 text-rose-700 text-xs font-extrabold tracking-wide">
                            HẾT HÀNG
                        </span>
                    @endif
                </div>

                <div class="mt-4 flex items-end gap-3">
                    <div class="text-2xl font-extrabold text-amber-600">
                        {{ number_format((float) $product->base_price, 0, ',', '.') }}đ
                    </div>
                    @if ($hasVariantPrices)
                        <div class="text-sm text-slate-500">(Giá có thể thay đổi theo size)</div>
                    @endif
                </div>

                @if ($product->description)
                    <p class="mt-4 text-sm text-slate-600 leading-7">
                        {{ $product->description }}
                    </p>
                @endif

                <form class="mt-6 space-y-5" method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}" />

                    @if ($product->variants->count() > 0)
                        <div>
                            <div class="flex items-center justify-between">
                                <p class="text-xs font-semibold tracking-wide uppercase text-slate-700">Chọn size</p>
                            </div>
                            <div class="mt-3 grid grid-cols-5 gap-2">
                                @foreach ($product->variants as $variant)
                                    @php
                                        $vStock = (int) $variant->stock;
                                        $vIsOut = $vStock <= 0;
                                        $vIsLow = $vStock > 0 && $vStock <= \App\Models\ProductVariant::LOW_STOCK_THRESHOLD;
                                    @endphp
                                    <label class="block">
                                        <input
                                            type="radio"
                                            name="variant_id"
                                            value="{{ $variant->id }}"
                                            class="peer sr-only"
                                            {{ (string) $variant->id === (string) $selectedVariantId ? 'checked' : '' }}
                                            {{ $vIsOut ? 'disabled' : '' }}
                                            required
                                        />
                                        <span class="relative inline-flex w-full items-center justify-center h-10 rounded border border-slate-200 text-sm text-slate-700 peer-checked:border-slate-900 peer-checked:bg-slate-900 peer-checked:text-white {{ $vIsOut ? 'opacity-40 cursor-not-allowed' : '' }}">
                                            <span class="leading-none">{{ $variant->size }}</span>

                                            @if ($vIsOut)
                                                <span class="absolute -top-1 -right-1 inline-flex items-center h-5 px-2 rounded-full bg-rose-50 border border-rose-200 text-rose-700 text-[10px] font-bold">
                                                    Hết
                                                </span>
                                            @elseif ($vIsLow)
                                                <span class="absolute -top-1 -right-1 inline-flex items-center h-5 px-2 rounded-full bg-amber-50 border border-amber-200 text-amber-800 text-[10px] font-bold">
                                                    Còn {{ $vStock }}
                                                </span>
                                            @endif
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('variant_id')" class="mt-2" />

                            @if ($isAllVariantsOutOfStock)
                                <div class="mt-3 px-4 py-3 rounded-xl text-sm bg-rose-50 border border-rose-200 text-rose-900">
                                    Sản phẩm hiện đã hết hàng. Vui lòng quay lại sau.
                                </div>
                            @endif
                        </div>
                    @endif

                    @if (!$isAllVariantsOutOfStock)
                        <div>
                            <p class="text-xs font-semibold tracking-wide uppercase text-slate-700">Số lượng</p>
                            <div class="mt-3 inline-flex items-center rounded-lg border border-slate-200 bg-white overflow-hidden">
                                <button
                                    type="button"
                                    class="h-10 w-10 inline-flex items-center justify-center text-slate-700 hover:bg-slate-50"
                                    onclick="const i=this.parentElement.querySelector('input[name=quantity]'); i.value=Math.max(1, (+i.value||1)-1);"
                                    aria-label="Giảm số lượng"
                                >
                                    −
                                </button>
                                <input
                                    name="quantity"
                                    type="number"
                                    min="1"
                                    max="99"
                                    value="{{ $qty }}"
                                    class="h-10 w-14 text-center text-sm outline-none border-x border-slate-200"
                                />
                                <button
                                    type="button"
                                    class="h-10 w-10 inline-flex items-center justify-center text-slate-700 hover:bg-slate-50"
                                    onclick="const i=this.parentElement.querySelector('input[name=quantity]'); i.value=Math.min(99, (+i.value||1)+1);"
                                    aria-label="Tăng số lượng"
                                >
                                    +
                                </button>
                            </div>
                        </div>
                    @endif

                    <div class="pt-1">
                        <button type="submit" class="w-full h-12 rounded-xl bg-amber-400 text-slate-900 text-sm font-extrabold tracking-wide hover:bg-amber-300 disabled:opacity-50 disabled:cursor-not-allowed" {{ $isAllVariantsOutOfStock ? 'disabled' : '' }}>
                            {{ $isAllVariantsOutOfStock ? 'HẾT HÀNG' : 'MUA HÀNG' }}
                        </button>
                        <a href="{{ route('cart.index') }}" class="mt-3 block text-center text-sm text-slate-600 hover:text-slate-900">
                            Xem giỏ hàng
                        </a>
                    </div>
                </form>

            </div>
        </section>

        <section class="mt-10">
            <div class="border-b border-slate-200">
                <div class="flex gap-6 text-sm font-semibold">
                    <a href="#mo-ta" class="py-3 border-b-2 border-slate-900 text-slate-900">Mô tả sản phẩm</a>
                    <a href="#huong-dan" class="py-3 border-b-2 border-transparent text-slate-600 hover:text-slate-900">Hướng dẫn bảo quản</a>
                </div>
            </div>

            <div id="mo-ta" class="mt-5 grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-8 bg-white border border-slate-200 rounded-xl p-6">
                    <h2 class="text-sm font-extrabold tracking-wide uppercase text-slate-900">Kỹ thuật & Hiệu suất</h2>
                    <p class="mt-3 text-sm text-slate-600 leading-7">
                        {{ $product->description ?: 'Thông tin mô tả đang được cập nhật.' }}
                    </p>
                </div>
                <div id="huong-dan" class="lg:col-span-4 bg-slate-900 text-white rounded-xl p-6">
                    <h3 class="text-sm font-extrabold tracking-wide uppercase">Hướng dẫn bảo quản</h3>
                    <p class="mt-3 text-sm text-slate-200 leading-7">
                        Đang cập nhật.
                    </p>
                </div>
            </div>
        </section>

        @if (!empty($relatedProducts) && $relatedProducts->count() > 0)
            <section class="mt-12">
                <div class="flex items-center justify-between gap-4">
                    <h2 class="text-lg font-semibold">Sản phẩm liên quan</h2>
                    <a href="{{ route('products.index') }}" class="text-sm text-slate-600 hover:text-slate-900">Xem tất cả</a>
                </div>
                <div class="mt-5 grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($relatedProducts as $rp)
                        <a href="{{ route('products.show', $rp) }}" class="group bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-sm transition">
                            <div class="aspect-square bg-slate-100">
                                @if ($rp->image_path)
                                    <img src="{{ asset('storage/' . $rp->image_path) }}" alt="{{ $rp->name }}" class="h-full w-full object-contain group-hover:scale-[1.02] transition" />
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-slate-400">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M3 3h18v18H3V3z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <p class="text-xs text-slate-500">{{ $rp->category?->name ?? 'Sản phẩm' }}</p>
                                <h3 class="mt-1 text-sm font-semibold text-slate-900">{{ $rp->name }}</h3>
                                <div class="mt-2 text-sm font-bold text-slate-900">
                                    {{ number_format((float) $rp->base_price, 0, ',', '.') }}đ
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

</x-store-layout>