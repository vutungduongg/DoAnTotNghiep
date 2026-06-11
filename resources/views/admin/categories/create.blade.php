@extends('admin.layout', ['title' => 'Thêm danh mục'])

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-semibold text-gray-900">Thêm danh mục</h1>

    <form class="mt-5 space-y-4" method="POST" action="{{ Route::has('admin.categories.store') ? route('admin.categories.store') : route('admin.dashboard') }}">
        @csrf

        <div>
            <label class="text-xs text-gray-600">Tên</label>
            <input name="name" value="{{ old('name') }}" required class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
            @error('name')<div class="text-sm mt-2 text-rose-600">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="text-xs text-gray-600">Slug (có thể để trống)</label>
            <input name="slug" value="{{ old('slug') }}" class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
            @error('slug')<div class="text-sm mt-2 text-rose-600">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="text-xs text-gray-600">Mô tả</label>
            <textarea name="description" rows="4" class="w-full mt-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300">{{ old('description') }}</textarea>
            @error('description')<div class="text-sm mt-2 text-rose-600">{{ $message }}</div>@enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-gray-700">
            <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-200" {{ old('is_active') ? 'checked' : '' }} />
            Kích hoạt
        </label>

        <div class="flex gap-3">
            <button class="px-4 py-2 rounded-lg text-sm font-semibold bg-emerald-600 text-white hover:bg-emerald-700">Lưu</button>
            <a href="{{ Route::has('admin.categories.index') ? route('admin.categories.index') : route('admin.dashboard') }}" class="px-4 py-2 rounded-lg text-sm bg-gray-900 text-white hover:bg-gray-800" style="text-decoration:none;">Hủy</a>
        </div>
    </form>
</div>
@endsection
