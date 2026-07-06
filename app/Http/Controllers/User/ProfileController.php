<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cookie;
use MoveMoveIo\DaData\Facades\DaDataAddress;
use MoveMoveIo\DaData\Enums\Language;

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
        $data = ['email' => $request->email];
        if ($request->name) array_merge($data, [
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        $request->user()->fill($data);

        if ($request->user()->isDirty('email')) $request->user()->email_verified_at = null;

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
            /** @var array $result */
            $result = (array) DaDataAddress::geolocate($request->lat, $request->lon, 1, 100, Language::RU);

            if (empty($result['suggestions']) || !$result['suggestions'][0]['data']['city']) {
                $city = config('app.default_city');
                $source = 'default';
                $locale = 'ru';
            } else {
                $city = $result['suggestions'][0]['data']['city'];
                $source = 'geo';
                $locale = $result['suggestions'][0]['data']['country_iso_code'] == 'RU' ? 'ru' : 'en';
            }
        } catch (\Exception $e) {
            $city = config('app.default_city');
            $source = 'default';
            $locale = 'ru';
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

    public function updateSettings(Request $request, string $setting)
    {
        $settings = $request->user()->settings;
        $settings->{$setting} = $request->settings;
        $settings->save();

        return response()->json(['success' => true, 'message' => __('Settings updated successfully')] , 200);
    }

    public function generateToken(Request $request)
    {
        $request->user()->tokens()->delete();

        $token = $request->user()->createToken('api-access');

        return response()->json([
            'success' => true,
            'token' => $token->plainTextToken
        ]);
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

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
