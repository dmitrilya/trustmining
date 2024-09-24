<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile')->with('status', 'profile-updated');
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

    public function notifications(Request $request): View
    {
        $notifications = $request->user()->notifications()->with(['notificationType', 'notificationable']);

        if ($request->notificationable_types && count($request->notificationable_types))
            $notifications = $notifications->whereIn('notificationable_type', $request->notificationable_types);

        return view('notification.index', [
            'notifications' => $notifications->latest()->paginate(50)
        ]);
    }

    public function notificationsCheck(Request $request)
    {
        $request->user()->notifications()->update(['checked' => true]);

        return response()->json(['success' => true], 200);
    }
}
