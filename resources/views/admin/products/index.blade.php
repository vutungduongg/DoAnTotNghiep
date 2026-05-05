@extends('admin.layout', ['title' => 'Sản phẩm'])

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Sản phẩm</h1>
            <p class="text-sm mt-1 text-gray-500">Thêm, sửa, xóa và cập nhật thông tin sản phẩm.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="px-4 py-2 rounded-lg text-sm font-semibold bg-emerald-600 text-white hover:bg-emerald-700" style="text-decoration:none;">Thêm sản phẩm</a>
    </div>

    <form class="mt-5 flex flex-wrap gap-3" method="GET" action="{{ route('admin.products.index') }}">
        <input name="q" value="{{ $q }}" placeholder="Tìm theo tên..." class="flex-1 min-w-[220px] px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
        <select name="category" class="px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300">
            <option value="">Tất cả danh mục</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" @selected($category === $cat->slug)>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button class="px-4 py-2 rounded-lg text-sm font-semibold bg-gray-900 text-white hover:bg-gray-800">Lọc</button>
    </form>

    <div class="mt-5 rounded-xl overflow-hidden bg-white border border-gray-200">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                <tr>
                    <th class="text-left px-4 py-3">ID</th>
                    <th class="text-left px-4 py-3">Tên</th>
                    <th class="text-left px-4 py-3">Danh mục</th>
                    <th class="text-left px-4 py-3">Giá</th>
                    <th class="text-left px-4 py-3">Kích hoạt</th>
                    <th class="text-right px-4 py-3">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($products as $p)
                    <tr>
                        <td class="px-4 py-3 text-gray-500">{{ $p->id }}</td>
                        <td class="px-4 py-3 text-gray-900">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                                    @if($p->image_path)
                                        <img src="{{ asset('storage/'.$p->image_path) }}" alt="{{ $p->name }}" style="width:100%; height:100%; object-fit:cover;" />
                                    @endif
                                </div>
                                <div>
                                    <div class="font-semibold">{{ $p->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $p->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $p->category?->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ number_format((float)$p->base_price, 0, ',', '.') }} đ</td>
                        <td class="px-4 py-3">
                            @if($p->is_active)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 border border-emerald-200 text-emerald-700">Có</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-50 border border-gray-200 text-gray-600">Không</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.products.edit', $p) }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700" style="text-decoration:none;">Sửa</a>
                            <form class="inline" method="POST" action="{{ route('admin.products.destroy', $p) }}" onsubmit="return confirm('Xóa sản phẩm này?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-sm ml-3 font-semibold text-rose-600 hover:text-rose-700">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-5">{{ $products->links() }}</div>
</div>
@endsection
