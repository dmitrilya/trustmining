<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cookie;
use MoveMoveIo\DaData\Facades\DaDataAddress;

use App\Http\Traits\NotificationTrait;

class ProfileController extends Controller
{
    use NotificationTrait;

    /**
     * Display the user's profile form.
     */
    public function show(Request $request)
    {
        return view('profile.show', ['user' => $request->user()]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $cyr = [' ', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'];
        $lat = ['_', 'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sht', 'a', 'i', 'y', 'e', 'yu', 'ya', 'a', 'b', 'v', 'g', 'd', 'e', 'io', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'ts', 'ch', 'sh', 'sht', 'a', 'i', 'y', 'e', 'yu', 'ya'];

        $request->user()->fill([
            'name' => $request->name,
            'url_name' => strtolower(str_replace($cyr, $lat, $request->name)),
            'email' => $request->email,
        ]);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile')->with('status', 'profile-updated');
    }

    public function locale(Request $request)
    {
        if (! in_array($request->locale, ['en', 'ru'])) {
            abort(400);
        }

        app()->setLocale($request->locale);
        session()->put('locale', $request->locale);

        return back();
    }

    public function location(Request $request)
    {
        if ($request->has('default')) {
            $city = config('app.default_city');
            $locale = 'ru';

            app()->setLocale($locale);
            session(['user_location' => [
                'city' => $city,
                'source' => 'default',
                'updated_at' => now()->timestamp,
            ], 'locale' => $locale]);

            return response()->json(['city' => $city]);
        }

        try {
            $result = DaDataAddress::geolocate($request->lat, $request->lon, 1, 50);
        } catch (\Exception $e) {
            $result['suggestions'][0]['data']['city'] = config('app.default_city');
            $source = 'default';
            $result['suggestions'][0]['data']['country_iso_code'] = 'RU';
        }

        if (empty($result['suggestions']) || !$result['suggestions'][0]['data']['city']) {
            $city = config('app.default_city');
            $source = 'default';
            $locale = 'ru';
        } else {
            $city = $result['suggestions'][0]['data']['city'];
            $source = 'geo';
            $locale = $result['suggestions'][0]['data']['country_iso_code'] == 'RU' ? 'ru' : 'en';
        }

        app()->setLocale($locale);
        session(['user_location' => [
            'city' => $city,
            'source' => $source,
            'updated_at' => now()->timestamp,
        ], 'locale' => $locale]);

        return response()->json(['city' => $city]);
    }

    public function changeTheme(Request $request)
    {
        Cookie::queue('app_theme', $request->theme, 60 * 24 * 30);

        return response('', 200);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        \Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
