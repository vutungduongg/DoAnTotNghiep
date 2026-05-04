<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    private function googleDriver()
    {
        $driver = Socialite::driver('google');

        if (app()->environment('local')) {
            $driver = $driver->stateless();
        }

        return $driver;
    }

    public function redirect()
    {
        if (!config('services.google.client_id') || !config('services.google.client_secret')) {
            return redirect()->route('login')->withErrors([
                'email' => 'Chưa cấu hình đăng nhập Google. Vui lòng cập nhật GOOGLE_CLIENT_ID và GOOGLE_CLIENT_SECRET trong file .env.',
            ]);
        }

        return $this->googleDriver()->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = $this->googleDriver()->user();
        } catch (Throwable) {
            return redirect()->route('login')->withErrors([
                'email' => 'Đăng nhập Google thất bại. Vui lòng thử lại.',
            ]);
        }

        $user = User::query()->where('google_id', $googleUser->getId())->first();

        $email = $googleUser->getEmail();
        if (!$email) {
            return redirect()->route('login')->withErrors([
                'email' => 'Tài khoản Google không cung cấp email.',
            ]);
        }

        if (!$user && $email) {
            $user = User::query()->where('email', $email)->first();
        }

        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName() ?: ($googleUser->getNickname() ?: 'User'),
                'email' => $email,
                'password' => Hash::make(Str::random(32)),
                'google_id' => $googleUser->getId(),
                'google_avatar' => $googleUser->getAvatar(),
            ]);
        } else {
            $user->forceFill([
                'google_id' => $googleUser->getId(),
                'google_avatar' => $googleUser->getAvatar(),
            ])->save();
        }

        Auth::login($user, true);

        return redirect()->route('products.index');
    }
}
