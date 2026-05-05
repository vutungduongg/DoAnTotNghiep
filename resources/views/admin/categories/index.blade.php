@extends('admin.layout', ['title' => 'Danh mục'])

@section('content')
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Danh mục</h1>
                <p class="text-sm mt-1 text-gray-500">Quản lý các loại sản phẩm như giày, áo, phụ kiện.</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 rounded-lg text-sm font-semibold bg-emerald-600 text-white hover:bg-emerald-700" style="text-decoration:none;">Thêm danh mục</a>
        </div>

        <form class="mt-5 flex gap-3" method="GET" action="{{ route('admin.categories.index') }}">
            <input name="q" value="{{ $q }}" placeholder="Tìm theo tên/slug..." class="flex-1 px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
            <button class="px-4 py-2 rounded-lg text-sm font-semibold bg-gray-900 text-white hover:bg-gray-800">Tìm</button>
        </form>

        <div class="mt-5 rounded-xl overflow-hidden bg-white border border-gray-200">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                    <tr>
                        <th class="text-left px-4 py-3">ID</th>
                        <th class="text-left px-4 py-3">Tên</th>
                        <th class="text-left px-4 py-3">Slug</th>
                        <th class="text-left px-4 py-3">Kích hoạt</th>
                        <th class="text-right px-4 py-3">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($categories as $cat)
                        <tr>
                            <td class="px-4 py-3 text-gray-500">{{ $cat->id }}</td>
                            <td class="px-4 py-3 text-gray-900 font-semibold">{{ $cat->name }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $cat->slug }}</td>
                            <td class="px-4 py-3">
                                @if($cat->is_active)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 border border-emerald-200 text-emerald-700">Có</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-50 border border-gray-200 text-gray-600">Không</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('admin.categories.edit', $cat) }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700" style="text-decoration:none;">Sửa</a>
                                <form class="inline" method="POST" action="{{ route('admin.categories.destroy', $cat) }}" onsubmit="return confirm('Xóa danh mục này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-sm ml-3 font-semibold text-rose-600 hover:text-rose-700">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500">Chưa có danh mục nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-5">{{ $categories->links() }}</div>
    </div>
@endsection
