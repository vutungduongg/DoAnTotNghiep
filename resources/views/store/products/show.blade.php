<x-store-layout :title="$product->name">
<div style="background:#030712; min-height:100vh;">
    <div style="max-width:1152px; margin:0 auto; padding:32px 24px;">

        {{-- Breadcrumb --}}
        <nav style="display:flex; align-items:center; gap:8px; font-size:12px; color:#6b7280; margin-bottom:24px;">
            <a href="{{ route('products.index') }}" style="color:#6b7280; text-decoration:none;" onmouseover="this.style.color='#fbbf24'" onmouseout="this.style.color='#6b7280'">Sản phẩm</a>
            <span>/</span>
            @if ($product->category)
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}"
                   style="color:#6b7280; text-decoration:none;" onmouseover="this.style.color='#fbbf24'" onmouseout="this.style.color='#6b7280'">
                   {{ $product->category->name }}
                </a>
                <span>/</span>
            @endif
            <span style="color:#9ca3af;">{{ $product->name }}</span>
        </nav>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:48px; align-items:start;">

            {{-- ẢNH --}}
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div style="aspect-ratio:1/1; background:#111827; border-radius:12px; overflow:hidden; border:1px solid #1f2937; display:flex; align-items:center; justify-content:center;">
                    @if ($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}"
                            alt="{{ $product->name }}"
                            style="width:100%; height:100%; object-fit:contain; padding:24px;">
                    @else
                        <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24" style="color:#374151;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5M3 3h18v18H3V3z"/>
                        </svg>
                    @endif
                </div>

                @if ($product->images && $product->images->count() > 1)
                    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:8px;">
                        @foreach ($product->images->take(4) as $img)
                            <div style="aspect-ratio:1/1; background:#111827; border-radius:8px; overflow:hidden; border:1px solid #1f2937; cursor:pointer;">
                                <img src="{{ asset('storage/' . $img->image_path) }}"
                                    alt="{{ $product->name }}"
                                    style="width:100%; height:100%; object-fit:contain; padding:8px;">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- INFO + FORM --}}
            <div style="display:flex; flex-direction:column; gap:0;">

                @if ($product->category)
                    <span style="font-size:11px; font-weight:600; color:#fbbf24; letter-spacing:0.1em; text-transform:uppercase; margin-bottom:10px; display:block;">
                        {{ $product->category->name }}
                    </span>
                @endif

                <h1 style="font-size:24px; font-weight:700; color:#f3f4f6; line-height:1.3; margin:0 0 20px 0;">
                    {{ $product->name }}
                </h1>

                {{-- Giá --}}
                <div style="display:flex; align-items:baseline; gap:12px; margin-bottom:20px;">
                    <span style="font-size:28px; font-weight:700; color:#fbbf24;">
                        {{ number_format((float) $product->base_price, 0, ',', '.') }} đ
                    </span>
                    @if ($product->original_price && $product->original_price > $product->base_price)
                        @php $pct = round((1 - $product->base_price / $product->original_price) * 100); @endphp
                        <span style="font-size:16px; color:#4b5563; text-decoration:line-through;">
                            {{ number_format((float) $product->original_price, 0, ',', '.') }} đ
                        </span>
                        <span style="padding:2px 8px; background:#ef4444; color:#fff; font-size:12px; font-weight:700; border-radius:4px;">
                            -{{ $pct }}%
                        </span>
                    @endif
                </div>

                {{-- Mô tả --}}
                @if ($product->description)
                    <div style="font-size:14px; color:#9ca3af; line-height:1.7; border-top:1px solid #1f2937; padding-top:20px; margin-bottom:24px;">
                        {{ $product->description }}
                    </div>
                @endif

                {{-- FORM --}}
                <form method="POST" action="{{ route('cart.add') }}" style="display:flex; flex-direction:column; gap:20px;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}" />

                    {{-- Size --}}
                    @if ($product->variants->count() > 0)
                        <div>
                            <p style="font-size:11px; font-weight:600; color:#9ca3af; letter-spacing:0.08em; text-transform:uppercase; margin:0 0 10px 0;">Chọn Size</p>
                            <div style="display:flex; flex-wrap:wrap; gap:8px;">
                                @foreach ($product->variants as $i => $variant)
                                    <label style="cursor:pointer;">
                                        <input type="radio" name="variant_id" value="{{ $variant->id }}"
                                               class="sr-only peer"
                                               {{ $i === 0 ? 'checked' : '' }} required>
                                        <span class="peer-checked:border-amber-400 peer-checked:text-amber-400 peer-checked:bg-amber-400/10"
                                              style="display:block; padding:8px 16px; border-radius:8px; border:1px solid #374151; font-size:14px; color:#d1d5db; transition:all 0.15s;">
                                            {{ $variant->size }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <x-input-error :messages="$errors->get('variant_id')" class="mt-2" style="color:#f87171; font-size:12px;" />
                        </div>
                    @endif

                    {{-- Số lượng --}}
                    <div>
                        <p style="font-size:11px; font-weight:600; color:#9ca3af; letter-spacing:0.08em; text-transform:uppercase; margin:0 0 10px 0;">Số Lượng</p>
                        <div style="display:flex; align-items:center;">
                            <button type="button" onclick="const i=this.nextElementSibling;i.value=Math.max(1,+i.value-1)"
                                style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; background:#1f2937; border:1px solid #374151; border-radius:8px 0 0 8px; color:#d1d5db; font-size:16px; cursor:pointer;">
                                −
                            </button>
                            <input type="number" name="quantity" value="1" min="1" max="99"
                                style="width:56px; height:36px; text-align:center; background:#1f2937; border-top:1px solid #374151; border-bottom:1px solid #374151; border-left:none; border-right:none; font-size:14px; color:#e5e7eb; outline:none;">
                            <button type="button" onclick="const i=this.previousElementSibling;i.value=Math.min(99,+i.value+1)"
                                style="width:36px; height:36px; display:flex; align-items:center; justify-content:center; background:#1f2937; border:1px solid #374151; border-radius:0 8px 8px 0; color:#d1d5db; font-size:16px; cursor:pointer;">
                                +
                            </button>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div style="display:flex; gap:12px; padding-top:8px;">
                        <button type="submit"
                            style="flex:1; padding:14px; background:#fbbf24; color:#111827; font-size:14px; font-weight:700; border-radius:8px; border:none; cursor:pointer;">
                            Thêm vào giỏ hàng
                        </button>
                        <a href="{{ route('cart.index') }}"
                           style="padding:14px 20px; border:1px solid #374151; color:#9ca3af; font-size:14px; border-radius:8px; text-decoration:none; white-space:nowrap;">
                            Xem giỏ
                        </a>
                    </div>
                </form>

                <div style="margin-top:24px; padding-top:24px; border-top:1px solid #1f2937;">
                    <a href="{{ route('products.index') }}"
                       style="font-size:12px; color:#6b7280; text-decoration:none;"
                       onmouseover="this.style.color='#fbbf24'" onmouseout="this.style.color='#6b7280'">
                        ← Tiếp tục mua sắm
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</x-store-layout>