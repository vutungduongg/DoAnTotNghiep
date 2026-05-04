<x-store-layout title="Sản phẩm">
<div class="flex gap-0 min-h-screen text-gray-100" style="background:#030712;">

    {{-- SIDEBAR --}}
<aside class="hidden lg:block w-64 shrink-0 px-6 py-8"
       style="background:#111827; border-right:1px solid #1f2937;">

    {{-- Danh mục --}}
    <div style="margin-bottom:32px;">
        <p style="color:#f3f4f6; font-size:13px; font-weight:600; letter-spacing:0.05em; text-transform:uppercase; margin-bottom:16px;">
            Danh Mục Sản Phẩm
        </p>
        <div style="display:flex; flex-direction:column; gap:12px;">
            @foreach ($categories as $cat)
            <label style="display:flex; align-items:center; gap:10px; cursor:pointer;">
                <input type="checkbox"
                    name="category[]"
                    value="{{ $cat->slug }}"
                    form="filter-form"
                    {{ in_array($cat->slug, (array)($filters['category'] ?? [])) ? 'checked' : '' }}
                    style="width:16px; height:16px; border-radius:4px; accent-color:#fbbf24; cursor:pointer; flex-shrink:0;">
                <span style="color:#9ca3af; font-size:14px;">{{ $cat->name }}</span>
            </label>
            @endforeach
        </div>
    </div>

    {{-- Khoảng giá --}}
    <div style="margin-bottom:32px;">
        <p style="color:#f3f4f6; font-size:13px; font-weight:600; letter-spacing:0.05em; text-transform:uppercase; margin-bottom:16px;">
            Khoảng Giá
        </p>
        <div style="display:flex; flex-direction:column; gap:10px;">
            <div style="position:relative;">
                <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:12px; color:#6b7280;">từ</span>
                <input form="filter-form" name="min_price" value="{{ $filters['min_price'] ?? '' }}"
                    placeholder="0"
                    style="width:100%; padding:8px 12px 8px 32px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;">
            </div>
            <div style="position:relative;">
                <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:12px; color:#6b7280;">đến</span>
                <input form="filter-form" name="max_price" value="{{ $filters['max_price'] ?? '' }}"
                    placeholder="10.000.000"
                    style="width:100%; padding:8px 12px 8px 40px; background:#1f2937; border:1px solid #374151; border-radius:8px; font-size:13px; color:#e5e7eb; outline:none; box-sizing:border-box;">
            </div>
        </div>
    </div>

    {{-- Buttons --}}
    <div style="display:flex; flex-direction:column; gap:8px;">
        <button form="filter-form" type="submit"
            style="width:100%; padding:10px; background:#fbbf24; color:#111827; font-size:14px; font-weight:600; border-radius:8px; border:none; cursor:pointer;">
            Áp dụng
        </button>
        <a href="{{ route('products.index') }}"
            style="display:block; width:100%; padding:10px; border:1px solid #374151; color:#9ca3af; font-size:14px; text-align:center; border-radius:8px; text-decoration:none; box-sizing:border-box;">
            Xóa bộ lọc
        </a>
    </div>
</aside>

    {{-- MAIN --}}
    <div class="flex-1 min-w-0 px-6 py-6">

        <form id="filter-form" method="GET" action="{{ route('products.index') }}">
            <div class="flex flex-wrap items-center gap-3 mb-6">
                <div class="relative flex-1 min-w-[200px]">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:#6b7280;"
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                    <input name="q" value="{{ $filters['q'] ?? '' }}"
                        placeholder="Tìm kiếm sản phẩm..."
                        class="w-full pl-9 pr-4 py-2.5 rounded-lg text-sm focus:outline-none"
                        style="background:#1f2937; border:1px solid #374151; color:#e5e7eb;">
                </div>

                <select name="sort" class="px-4 py-2.5 rounded-lg text-sm focus:outline-none cursor-pointer"
                        style="background:#1f2937; border:1px solid #374151; color:#d1d5db;">
                    <option value="">Sắp xếp</option>
                    <option value="price_asc" @selected(($filters['sort'] ?? '') == 'price_asc')>Giá tăng dần</option>
                    <option value="price_desc" @selected(($filters['sort'] ?? '') == 'price_desc')>Giá giảm dần</option>
                    <option value="newest" @selected(($filters['sort'] ?? '') == 'newest')>Mới nhất</option>
                </select>

                <button type="submit" class="px-5 py-2.5 text-sm font-semibold rounded-lg transition-colors"
                        style="background:#fbbf24; color:#111827;">
                    Tìm
                </button>
            </div>
        </form>

        <div class="flex items-center justify-between mb-5">
            <h1 class="text-lg font-semibold" style="color:#f3f4f6;">
                Sản phẩm bóng đá
                <span class="ml-2 text-sm font-normal" style="color:#6b7280;">({{ $products->total() }} sản phẩm)</span>
            </h1>
        </div>

        {{-- PRODUCT GRID --}}
        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse ($products as $product)
            <a href="{{ route('products.show', $product) }}"
                class="group flex flex-col rounded-lg overflow-hidden border transition-all duration-200 hover:border-amber-400/40"
                style="background:#111827; border-color:#1f2937;">

                {{-- IMAGE --}}
                <div class="relative overflow-hidden" style="aspect-ratio:1/1; background:#0d1520;">
                    @if ($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}"
                            alt="{{ $product->name }}"
                            class="absolute inset-0 w-full h-full transition-transform duration-300 group-hover:scale-[1.04]"
                            style="object-fit:cover; object-position:center;">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24" style="color:#374151;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M3 3h18v18H3V3z"/>
                            </svg>
                        </div>
                    @endif
                    @if ($product->original_price && $product->original_price > $product->base_price)
                        @php $pct = round((1 - $product->base_price / $product->original_price) * 100); @endphp
                        <span class="absolute top-2 left-2 px-1.5 py-0.5 text-white font-bold rounded"
                            style="background:#ef4444; font-size:10px;">-{{ $pct }}%</span>
                    @endif
                </div>

                {{-- INFO --}}
                <div class="px-3 py-3 flex flex-col gap-1 flex-1" style="border-top:1px solid #1f2937;">
                    <h3 class="text-xs font-semibold leading-snug line-clamp-2 group-hover:text-amber-400 transition-colors"
                        style="color:#f3f4f6;">
                        {{ $product->name }}
                    </h3>
                    <div class="flex items-baseline gap-1.5 flex-wrap mt-auto pt-2">
                        <span class="text-sm font-bold" style="color:#fbbf24;">
                            {{ number_format((float) $product->base_price, 0, ',', '.') }}đ
                        </span>
                        @if ($product->original_price && $product->original_price > $product->base_price)
                            <span class="text-xs line-through" style="color:#4b5563;">
                                {{ number_format((float) $product->original_price, 0, ',', '.') }}đ
                            </span>
                        @endif
                    </div>
                </div>

            </a>
            @empty
            <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                <p class="text-sm" style="color:#6b7280;">Không tìm thấy sản phẩm phù hợp.</p>
                <a href="{{ route('products.index') }}" class="mt-3 text-xs" style="color:#fbbf24;">Xem tất cả</a>
            </div>
            @endforelse
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
    </div>
</div>
</x-store-layout>