@extends('admin.layout', ['title' => 'Đơn hàng'])

@section('content')
<div class="max-w-6xl mx-auto">
    @php
        $badge = function ($status) {
            return match ($status) {
                \App\Models\Order::STATUS_DELIVERED => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                \App\Models\Order::STATUS_SHIPPING => 'bg-sky-50 text-sky-700 border-sky-200',
                \App\Models\Order::STATUS_CANCELLED => 'bg-rose-50 text-rose-700 border-rose-200',
                default => 'bg-amber-50 text-amber-700 border-amber-200',
            };
        };
    @endphp

    <div>
        <h1 class="text-2xl font-semibold text-gray-900">Đơn hàng</h1>
        <p class="text-sm mt-1 text-gray-500">Tìm kiếm đơn hàng và cập nhật trạng thái.</p>
    </div>

    <form class="mt-5 flex flex-wrap gap-3" method="GET" action="{{ route('admin.orders.index') }}">
        <input name="q" value="{{ $q }}" placeholder="Tìm theo mã đơn / email / SĐT / tên..." class="flex-1 min-w-[260px] px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300" />
        <select name="status" class="px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300">
            <option value="">Tất cả trạng thái</option>
            @foreach($statuses as $st)
                <option value="{{ $st }}" @selected($status === $st)>{{ $st }}</option>
            @endforeach
        </select>
        <button class="px-4 py-2 rounded-lg text-sm font-semibold bg-gray-900 text-white hover:bg-gray-800">Lọc</button>
    </form>

    <div class="mt-5 rounded-xl overflow-hidden bg-white border border-gray-200">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                <tr>
                    <th class="text-left px-4 py-3">ID</th>
                    <th class="text-left px-4 py-3">Mã đơn</th>
                    <th class="text-left px-4 py-3">Khách hàng</th>
                    <th class="text-left px-4 py-3">Tổng</th>
                    <th class="text-left px-4 py-3">Trạng thái</th>
                    <th class="text-right px-4 py-3">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($orders as $o)
                    <tr>
                        <td class="px-4 py-3 text-gray-500">{{ $o->id }}</td>
                        <td class="px-4 py-3 text-gray-900 font-semibold">{{ $o->order_number }}</td>
                        <td class="px-4 py-3 text-gray-700">
                            <div>{{ $o->customer_name }}</div>
                            <div class="text-xs text-gray-500">{{ $o->customer_email }}</div>
                        </td>
                        <td class="px-4 py-3 text-gray-700">{{ number_format((float)$o->total, 0, ',', '.') }} đ</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badge($o->status) }}">
                                {{ $o->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.orders.edit', $o) }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700" style="text-decoration:none;">Cập nhật</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-5">{{ $orders->links() }}</div>
</div>
@endsection
