@extends('admin.layout', ['title' => 'Quản lý kho hàng'])

@section('content')
@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator $variants */
@endphp
<div class="max-w-6xl mx-auto">
    <div class="flex items-end justify-between gap-4 flex-wrap">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Quản lý kho hàng</h1>
            <p class="mt-1 text-sm text-gray-600">Theo dõi tồn kho theo từng biến thể (size). Cảnh báo khi còn <= {{ (int) $lowThreshold }} và hết hàng khi stock = 0.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="px-4 py-2 rounded-lg text-sm font-semibold bg-gray-900 text-white hover:bg-gray-800" style="text-decoration:none;">Quản lý sản phẩm</a>
    </div>

    @if ($errors->inventory->any())
        <div class="mt-4 px-4 py-3 rounded-lg text-sm bg-rose-50 border border-rose-200 text-rose-700">
            {{ $errors->inventory->first() }}
        </div>
    @endif

    <div class="mt-5 bg-white border border-gray-200 rounded-xl overflow-hidden">
        <div class="hidden md:grid grid-cols-12 gap-3 px-5 py-4 border-b border-gray-200 text-xs font-semibold tracking-wide uppercase text-gray-500">
            <div class="col-span-5">Sản phẩm</div>
            <div class="col-span-2">Danh mục</div>
            <div class="col-span-1">Size</div>
            <div class="col-span-2">Tồn kho</div>
            <div class="col-span-2">Cập nhật</div>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse ($variants as $v)
                @php
                    $stock = (int) $v->stock;
                    $isOut = $stock <= 0;
                    $isLow = $stock > 0 && $stock <= (int) $lowThreshold;
                @endphp

                <div class="px-5 py-4 grid grid-cols-1 md:grid-cols-12 gap-3 items-center">
                    <div class="md:col-span-5">
                        <div class="font-semibold text-gray-900">{{ $v->product?->name ?? ('#'.$v->product_id) }}</div>
                        <div class="mt-1 text-xs text-gray-500">SKU: {{ $v->sku ?: '-' }}</div>
                    </div>

                    <div class="md:col-span-2 text-sm text-gray-700">
                        {{ $v->product?->category?->name ?? '-' }}
                    </div>

                    <div class="md:col-span-1 text-sm font-semibold text-gray-900">
                        {{ $v->size }}
                    </div>

                    <div class="md:col-span-2">
                        <div class="inline-flex items-center gap-2">
                            <span class="text-sm font-semibold {{ $isOut ? 'text-rose-600' : ($isLow ? 'text-amber-700' : 'text-emerald-700') }}">
                                {{ $stock }}
                            </span>
                            @if ($isOut)
                                <span class="inline-flex items-center h-6 px-2 rounded bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold">Hết hàng</span>
                            @elseif ($isLow)
                                <span class="inline-flex items-center h-6 px-2 rounded bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold">Sắp hết</span>
                            @endif
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <form method="POST" action="{{ route('admin.inventory.update', $v) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PUT')
                            <input type="number" name="stock" min="0" value="{{ (int) $v->stock }}" class="w-24 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
                            <button class="px-3 py-2 rounded-lg text-sm font-semibold bg-emerald-600 text-white hover:bg-emerald-700">Lưu</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-5 py-10 text-center text-sm text-gray-600">Chưa có biến thể nào để quản lý kho.</div>
            @endforelse
        </div>

        <div class="px-5 py-4 border-t border-gray-200 flex items-center justify-between gap-3">
            <div class="text-sm text-gray-600">
                Trang {{ (int) $variants->currentPage() }} / {{ (int) $variants->lastPage() }} · Tổng {{ (int) $variants->total() }} biến thể
            </div>

            <div class="flex items-center gap-2">
                @if ($variants->onFirstPage())
                    <span class="px-3 py-2 rounded-lg text-sm bg-gray-100 text-gray-400 cursor-not-allowed">← Trước</span>
                @else
                    <a href="{{ $variants->previousPageUrl() }}" class="px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 text-gray-700 hover:bg-gray-50" style="text-decoration:none;">← Trước</a>
                @endif

                @if ($variants->hasMorePages())
                    <a href="{{ $variants->nextPageUrl() }}" class="px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 text-gray-700 hover:bg-gray-50" style="text-decoration:none;">Sau →</a>
                @else
                    <span class="px-3 py-2 rounded-lg text-sm bg-gray-100 text-gray-400 cursor-not-allowed">Sau →</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
