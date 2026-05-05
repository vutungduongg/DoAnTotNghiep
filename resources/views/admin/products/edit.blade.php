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
</div>
@endsection
