<x-guest-layout>
    <h1 class="text-xl font-semibold text-gray-900">Xác minh email</h1>
    <div class="mt-2 mb-4 text-sm text-gray-600">
        Vui lòng kiểm tra email và nhấn vào link xác minh để hoàn tất đăng ký. Nếu chưa nhận được email, bạn có thể yêu cầu gửi lại.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            Link xác minh mới đã được gửi đến email của bạn.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    Gửi lại email xác minh
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Đăng xuất
            </button>
        </form>
    </div>
</x-guest-layout>
