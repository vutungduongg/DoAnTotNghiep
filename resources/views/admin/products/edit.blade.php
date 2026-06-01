@extends('admin.layout', ['title' => 'Sửa sản phẩm'])

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-900">Sửa sản phẩm</h1>

    <form class="mt-5 space-y-4" method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label class="text-xs text-gray-600">Danh mục</label>
            <select name="category_id" class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300">
                <option value="">-- Chọn danh mục --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id) == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id')<div class="text-sm mt-2 text-rose-600">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="text-xs text-gray-600">Tên</label>
            <input name="name" value="{{ old('name', $product->name) }}" required class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
            @error('name')<div class="text-sm mt-2 text-rose-600">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="text-xs text-gray-600">Slug</label>
            <input name="slug" value="{{ old('slug', $product->slug) }}" required class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
            @error('slug')<div class="text-sm mt-2 text-rose-600">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="text-xs text-gray-600">Giá</label>
            <input name="base_price" value="{{ old('base_price', $product->base_price) }}" required class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
            @error('base_price')<div class="text-sm mt-2 text-rose-600">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="text-xs text-gray-600">Ảnh</label>
            <input type="file" name="image" class="w-full mt-1 text-sm text-gray-700" />
            @if($product->image_path)
                <div class="mt-3 w-[120px] h-[120px] rounded-xl overflow-hidden bg-gray-100 border border-gray-200">
                    <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" style="width:100%; height:100%; object-fit:cover;" />
                </div>
            @endif
            @error('image')<div class="text-sm mt-2 text-rose-600">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="text-xs text-gray-600">Mô tả</label>
            <textarea name="description" rows="5" class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300">{{ old('description', $product->description) }}</textarea>
            @error('description')<div class="text-sm mt-2 text-rose-600">{{ $message }}</div>@enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-200" {{ old('is_active', $product->is_active) ? 'checked' : '' }} />
            Kích hoạt
        </label>

        <div class="flex gap-3">
            <button class="px-4 py-2 rounded-lg text-sm font-semibold bg-emerald-600 text-white hover:bg-emerald-700">Cập nhật</button>
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 rounded-lg text-sm bg-gray-900 text-white hover:bg-gray-800" style="text-decoration:none;">Hủy</a>
        </div>
    </form>

    <div class="mt-10">
        <h2 class="text-xl font-semibold text-gray-900">Quản lý kho theo size</h2>
        <p class="mt-1 text-sm text-gray-600">Tồn kho được theo dõi theo từng biến thể (size). Khi stock = 0 thì người dùng sẽ không thể mua.</p>

        @if ($errors->variant->any())
            <div class="mt-4 px-4 py-3 rounded-lg text-sm bg-rose-50 border border-rose-200 text-rose-700">
                {{ $errors->variant->first() }}
            </div>
        @endif

        <div class="mt-4 bg-white border border-gray-200 rounded-xl p-4">
            <div class="hidden md:grid grid-cols-12 gap-3 text-xs font-semibold tracking-wide uppercase text-gray-500 px-2">
                <div class="col-span-2">Size</div>
                <div class="col-span-3">SKU</div>
                <div class="col-span-3">Giá (tùy chọn)</div>
                <div class="col-span-2">Tồn kho</div>
                <div class="col-span-2">Thao tác</div>
            </div>

            <div class="mt-3 space-y-3">
                @forelse ($product->variants as $v)
                    <div class="rounded-lg border border-gray-200 p-3">
                        <form method="POST" action="{{ route('admin.products.variants.update', [$product, $v]) }}" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                            @csrf
                            @method('PUT')

                            <div class="md:col-span-2">
                                <label class="text-xs text-gray-600">Size</label>
                                <input name="size" value="{{ old('size', $v->size) }}" required class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
                            </div>

                            <div class="md:col-span-3">
                                <label class="text-xs text-gray-600">SKU</label>
                                <input name="sku" value="{{ old('sku', $v->sku) }}" class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
                            </div>

                            <div class="md:col-span-3">
                                <label class="text-xs text-gray-600">Giá</label>
                                <input name="price" value="{{ old('price', $v->price) }}" placeholder="(trống = dùng giá gốc)" class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="text-xs text-gray-600">Tồn kho</label>
                                <input type="number" name="stock" min="0" value="{{ old('stock', (int) $v->stock) }}" required class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
                            </div>

                            <div class="md:col-span-2 flex gap-2">
                                <button class="px-3 py-2 rounded-lg text-sm font-semibold bg-emerald-600 text-white hover:bg-emerald-700">Lưu</button>
                                <button type="submit" form="delete-variant-{{ $v->id }}" class="px-3 py-2 rounded-lg text-sm font-semibold bg-rose-600 text-white hover:bg-rose-700" onclick="return confirm('Xóa biến thể này?');">Xóa</button>
                            </div>
                        </form>

                        <form id="delete-variant-{{ $v->id }}" method="POST" action="{{ route('admin.products.variants.destroy', [$product, $v]) }}" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @empty
                    <div class="text-sm text-gray-600">Chưa có biến thể. Hãy thêm size để quản lý tồn kho.</div>
                @endforelse
            </div>

            <div class="mt-5 pt-5 border-t border-gray-200">
                <h3 class="text-sm font-semibold text-gray-900">Thêm biến thể mới</h3>
                <form method="POST" action="{{ route('admin.products.variants.store', $product) }}" class="mt-3 grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                    @csrf

                    <div class="md:col-span-2">
                        <label class="text-xs text-gray-600">Size</label>
                        <input name="size" value="{{ old('size') }}" required class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
                    </div>

                    <div class="md:col-span-3">
                        <label class="text-xs text-gray-600">SKU</label>
                        <input name="sku" value="{{ old('sku') }}" class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
                    </div>

                    <div class="md:col-span-3">
                        <label class="text-xs text-gray-600">Giá</label>
                        <input name="price" value="{{ old('price') }}" placeholder="(trống = dùng giá gốc)" class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-xs text-gray-600">Tồn kho</label>
                        <input type="number" name="stock" min="0" value="{{ old('stock', 0) }}" required class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
                    </div>

                    <div class="md:col-span-2">
                        <button class="w-full px-3 py-2 rounded-lg text-sm font-semibold bg-gray-900 text-white hover:bg-gray-800">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
