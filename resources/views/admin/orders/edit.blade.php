@extends('admin.layout', ['title' => 'Cập nhật đơn hàng'])

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Cập nhật đơn hàng</h1>
            <p class="text-sm mt-1 text-gray-500">Mã đơn: {{ $order->order_number }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-lg text-sm bg-gray-900 text-white hover:bg-gray-800" style="text-decoration:none;">Quay lại</a>
    </div>

    <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="p-4 rounded-xl bg-white border border-gray-200">
            <div class="text-sm font-semibold text-gray-900">Thông tin khách</div>
            <div class="text-sm mt-3 text-gray-700 space-y-1">
                <div><span class="text-gray-500">Tên:</span> {{ $order->customer_name }}</div>
                <div><span class="text-gray-500">Email:</span> {{ $order->customer_email }}</div>
                <div><span class="text-gray-500">SĐT:</span> {{ $order->customer_phone }}</div>
                <div><span class="text-gray-500">Địa chỉ:</span> {{ $order->shipping_address }}</div>
            </div>
        </div>

        <div class="p-4 rounded-xl bg-white border border-gray-200">
            <div class="text-sm font-semibold text-gray-900">Cập nhật trạng thái</div>
            <form class="mt-3 space-y-3" method="POST" action="{{ route('admin.orders.update', $order) }}">
                @csrf
                @method('PATCH')

                <select name="status" class="w-full px-3 py-2 rounded-lg text-sm bg-white border border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:border-emerald-300">
                    @foreach($statuses as $st)
                        <option value="{{ $st }}" @selected(old('status', $order->status) === $st)>{{ $st }}</option>
                    @endforeach
                </select>
                @error('status')<div class="text-sm text-rose-600">{{ $message }}</div>@enderror

                <button class="px-4 py-2 rounded-lg text-sm font-semibold bg-emerald-600 text-white hover:bg-emerald-700">Lưu</button>
            </form>
        </div>
    </div>

    <div class="mt-5 p-4 rounded-xl bg-white border border-gray-200">
        <div class="text-sm font-semibold text-gray-900">Sản phẩm</div>
        <div class="mt-3 space-y-2">
            @foreach($order->items as $it)
                <div class="flex justify-between text-sm text-gray-700">
                    <div>{{ $it->product_name }} @if($it->variant_size) <span class="text-gray-500">(Size {{ $it->variant_size }})</span> @endif</div>
                    <div>{{ $it->quantity }} x {{ number_format((float)$it->price, 0, ',', '.') }} đ</div>
                </div>
            @endforeach
        </div>
        <div class="mt-4 border-t border-gray-200"></div>
        <div class="mt-3 text-sm text-gray-700">
            <div class="flex justify-between"><span class="text-gray-500">Tạm tính</span><span>{{ number_format((float)$order->subtotal, 0, ',', '.') }} đ</span></div>
            <div class="flex justify-between mt-1"><span class="text-gray-500">Ship</span><span>{{ number_format((float)$order->shipping_fee, 0, ',', '.') }} đ</span></div>
            <div class="flex justify-between mt-2 text-emerald-700 font-semibold"><span>Tổng</span><span>{{ number_format((float)$order->total, 0, ',', '.') }} đ</span></div>
        </div>
    </div>
</div>
@endsection
