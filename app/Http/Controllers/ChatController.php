<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\StoreMessageRequest;
use Illuminate\Http\Request;

use App\Http\Traits\FileTrait;
use App\Http\Traits\NotificationTrait;

use App\Models\User;
use App\Models\Chat;
use App\Models\Role;

class ChatController extends Controller
{
    use FileTrait, NotificationTrait;

    /**
     * Start the chat.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function chat(Request $request, User $user)
    {
        $auth = $request->user();

        if ($auth->id == $user->id) return back()->withErrors(['forbidden' => __('Unavailable chat.')]);;

        $chat = $auth->chats()->whereHas('users', function ($query) use ($user) {
            $query->where('id', $user->id);
        })->first();

        if (!$chat) {
            $chat = Chat::create();

            $chat->users()->attach([$auth->id, $user->id]);

            if ($request->ad) {
                $chat->messages()->create([
                    'user_id' => $auth->id,
                    'message' => __('Good afternoon Interested in the ad') . ' ' . route('ads.show', ['ad' => $request->ad]),
                    'images' => [],
                    'files' => []
                ]);
            }
        }

        return redirect()->route('chat', ['chat' => $chat->id]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return view('chat.index', [
            'auth' => $user,
            'chats' => $user->chats()->with(['messages', 'users'])->whereHas('users', function ($query) use ($user) {
                $notIn = [$user->id];

                if ($user->role->name != 'support') Role::where('name', 'support')->first()->users()->pluck('id')->merge($notIn);

                $query->whereNotIn('id', $notIn);
            })->get()->sortByDesc(function ($chat) {
                return $chat->messages->count() ? $chat->messages->reverse()->first()->created_at : $chat->created_at;
            })
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        $user = Auth::user();

        $chat->messages()->where('user_id', '!=', $user->id)->update(['checked' => 1]);

        return view('chat.show', [
            'auth' => $user,
            'messages' => $chat->messages,
            'activeChat' => $chat,
            'chats' => $user->chats()->with(['messages', 'users'])->whereHas('users', function ($query) use ($user) {
                $notIn = [$user->id];

                if ($user->role->name != 'support') Role::where('name', 'support')->first()->users()->pluck('id')->merge($notIn);

                $query->whereNotIn('id', $notIn);
            })->get()->sortByDesc(function ($chat) {
                return $chat->messages->count() ? $chat->messages->reverse()->first()->created_at : $chat->created_at;
            })
        ]);
    }

    /**
     * Send chat message.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function send(StoreMessageRequest $request, Chat $chat)
    {
        $user = $request->user();

        if (!$chat->users()->pluck('id')->contains($user->id)) response()->json(['success' => false], 200);

        $chat->messages()->where('user_id', '!=', $user->id)->update(['checked' => 1]);

        $message = $chat->messages()->create([
            'user_id' => $user->id,
            'message' => $request->message,
            'images' => [],
            'files' => []
        ]);

        if ($request->images) $message->images = $this->saveFiles($request->file('images'), 'chat', 'image', $message->id);

        if ($request->files) $message->files = $this->saveFilesWithName($request->file('files'), 'chat', 'file', $message->id);

        $message->save();

        if ($user->role->name == 'support')
            $this->notify('New message from support', $chat->users()->where('id', '!=', $user->id)->first(), 'App\Models\Message', $message);

        return response()->json(['success' => true], 200);
    }
}
