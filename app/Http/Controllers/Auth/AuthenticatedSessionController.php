<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Services\RouletteSpinService;
use App\Models\User\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        (new RouletteSpinService)->compareSpinsAfterLogin(auth()->id());

        return $request->redirect ? redirect($request->redirect) : redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Handle an incoming authentication from yandex.
     */
    public function yandexAuth(Request $request): RedirectResponse
    {
        if ($request->has('error')) {
            Log::channel('socials-auth')->info("[YANDEX] {Error after link}\n{$request->error_description}");
            return redirect()->route('login')->withErrors(['forbidden' => 'Ошибка авторизации через Яндекс: ' . $request->input('error_description', $request->error)]);
        }

        if (!$request->has('code')) return redirect()->route('login')->withErrors(['forbidden' => 'Код подтверждения не получен.']);

        try {
            $clientId = config('services.yandex_auth.id');
            $clientSecret = config('services.yandex_auth.secret');
            $credentials = base64_encode("{$clientId}:{$clientSecret}");

            $tokenResponse = Http::asForm()->withHeaders([
                'Authorization' => 'Basic ' . $credentials,
            ])->post('https://oauth.yandex.ru/token', [
                'grant_type' => 'authorization_code',
                'code'       => $request->code,
            ]);

            if ($tokenResponse->failed()) {
                Log::channel('socials-auth')->info("[YANDEX] {Getting OAuth}\n{$tokenResponse->body()}");
                return redirect()->route('login')->withErrors(['forbidden' => 'Не удалось получить токен доступа.']);
            }

            $accessToken = $tokenResponse->json('access_token');

            $userResponse = Http::withHeaders([
                'Authorization' => 'OAuth ' . $accessToken,
            ])->get('https://login.yandex.ru/info', [
                'format' => 'json',
            ]);

            if ($userResponse->failed()) {
                Log::channel('socials-auth')->info("[YANDEX] {Getting user info}\n{$userResponse->body()}");
                return redirect()->route('login')->withErrors(['forbidden' => 'Не удалось получить данные пользователя.']);
            }

            $yandexUser = $userResponse->json();
            $rawPhone = $yandexUser['default_phone']['number'] ?? null;

            if (!$rawPhone) return redirect()->route('login')
                ->withErrors(['forbidden' => 'В вашем Яндекс-аккаунте не привязан номер телефона. Пожалуйста, привяжите его в Яндексе или обратитесь в нашу поддержку.']);

            $cleanedPhone = preg_replace('/[^0-9]/', '', $rawPhone);
            $email = $yandexUser['default_email'] ?? null;
            $userQuery = User::where('phone', $cleanedPhone);

            if ($email) $userQuery = $userQuery->orWhere('email', $yandexUser['default_email']);

            $user = $userQuery->first();

            if (!$user) {
                $firstUser = User::orderByDesc('ordering_id')->first();
                $name = $yandexUser['real_name'] ?? $yandexUser['display_name'] ?? 'Yandex User';
                $user = User::create([
                    'ordering_id' => $firstUser ? $firstUser->ordering_id + 1 : 1,
                    'phone' => $cleanedPhone,
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'email' => $email,
                    'password' => Hash::make(Str::random(24)),
                ]);

                event(new Registered($user));
            }

            $request->session()->regenerate();

            Auth::login($user, true);

            (new RouletteSpinService)->compareSpinsAfterLogin(auth()->id());

            return $request->redirect ? redirect($request->redirect) : redirect()->intended(RouteServiceProvider::HOME);
        } catch (\Exception $e) {
            Log::channel('socials-auth')->info("[YANDEX] {Error catching}\n{$e->getMessage()}");
            return redirect()->route('login')->withErrors(['yandex' => 'Произошла непредвиденная ошибка при авторизации.']);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
