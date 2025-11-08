<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\StoreMessageRequest;
use Illuminate\Http\Request;

use App\Http\Traits\FileTrait;
use App\Http\Traits\NotificationTrait;

use App\Models\User;
use App\Models\Chat;
use App\Models\CRMConnection;
use App\Models\Role;

use App\Services\CRM\AmoCRMService;
use App\Services\CRM\CRMServiceFactory;

use Carbon\Carbon;

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
            $chat = isset($request->ad_id) ? Chat::create(['ad_id' => $request->ad_id]) : Chat::create();

            $chat->users()->attach([$auth->id, $user->id]);
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
            'chats' => $user->chats()->has('messages')->with(['messages', 'users'])->whereHas('users', function ($query) use ($user) {
                $notIn = [$user->id];

                if ($user->role->name != 'support') Role::where('name', 'support')->first()->users()->pluck('id')->merge($notIn);

                $query->whereNotIn('id', $notIn);
            })->get()->sortByDesc(fn($chat) => $chat->messages->reverse()->first()->created_at)
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
            'chats' => $user->chats()->has('messages')->with(['messages', 'users'])->whereHas('users', function ($query) use ($user) {
                $notIn = [$user->id];

                if ($user->role->name != 'support') Role::where('name', 'support')->first()->users()->pluck('id')->merge($notIn);

                $query->whereNotIn('id', $notIn);
            })->get()->sortByDesc(fn($chat) => $chat->messages->reverse()->first()->created_at)
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
        $addressee = $chat->users()->where('id', '!=', $user->id)->first();

        $chat->messages()->where('user_id', '!=', $user->id)->update(['checked' => 1]);

        $message = $chat->messages()->create([
            'user_id' => $user->id,
            'message' => $request->message,
            'images' => [],
            'files' => []
        ]);

        $files = [];

        if ($request->images) {
            $message->images = $this->saveFiles($request->file('images'), 'chat', 'image', $message->id);

            foreach ($request->images as $i => $file) {
                array_push($files, [
                    'type' => 'picture',
                    'file_name' => end(explode('/', $message->images[$i])),
                    'file_size' => filesize($file),
                    'mime_type' => mime_content_type($file),
                    'media' => Storage::url($message->images[$i]),
                ]);
            }
        }

        if ($request->files) {
            $message->files = $this->saveFilesWithName($request->file('files'), 'chat', 'file', $message->id);

            foreach ($request->files as $i => $file) {
                array_push($files, [
                    'type' => 'file',
                    'file_name' => $message->files[$i]['name'],
                    'file_size' => filesize($file),
                    'mime_type' => mime_content_type($file),
                    'media' => Storage::url($message->files[$i]['path']),
                ]);
            }
        }

        $message->save();

        if ($user->role->name == 'support')
            $this->notify('New message from support', collect([$addressee]), 'App\Models\Message', $message);
        else {
            if ($addressee->role->name == 'support')
                $this->notify('New message to support', collect([$addressee]), 'App\Models\Message', $message);
            else {
                foreach ($user->crmConnections()->with('crm_system')->get() as $crmConnection) {
                    $service = CRMServiceFactory::createService($crmConnection->crmSystem->name);

                    if ($request->message) $service->sendMessage($crmConnection->external_id, $chat->id, $addressee->id, $request->message, $message->id);
                    if (count($files)) $service->sendMessage($crmConnection->external_id, $chat->id, $addressee->id, $files);
                }

                foreach ($addressee->crmConnections()->with('crmSystem')->get() as $crmConnection) {
                    $service = CRMServiceFactory::createService($crmConnection->crmSystem->name);

                    if ($request->message) $service->sendMessage($crmConnection->external_id, $chat->id, $user->id, $request->message, $message->id, true, $user->name, $user->email);
                    if (count($files)) $service->sendMessage($crmConnection->external_id, $chat->id, $user->id, $files, true, $user->name, $user->email);
                }
            }
            event(new NewMessage($addressee, $message));
        }

        return response()->json(['success' => true], 200);
    }

    /**
     * Вебхук от амо
     */
    public function amocrmWebhook(Request $request, string $scope_id)
    {
        $service = new AmoCRMService();

        if ($service->signature($request->getContent()) != $request->header('HTTP_X_SIGNATURE')) return;

        $crmConnection = CRMConnection::where('external_id', $scope_id)->first();
        if (!$crmConnection) return;

        $chat = Chat::find($request->message['conversation']->client_id);
        if (!$chat) return;

        if ($request->message['message']->type == 'text') $message = $chat->messages()->create([
            'user_id' => $crmConnection->user_id,
            'message' => $request->message['message']->text,
            'images' => [],
            'files' => [],
            'created_at' => Carbon::createFromTimestamp($request->message['timestamp'])
        ]);
        else {
            $message = $chat->messages()->create([
                'user_id' => $crmConnection->user_id,
                'message' => null,
                'images' => [],
                'files' => [],
                'created_at' => Carbon::createFromTimestamp($request->message['timestamp'])
            ]);

            if ($request->message['message']->type == 'picture')
                $message->images = $this->saveFiles([file_get_contents($request->message['message']->media)], 'chat', 'image', $message->id);
            else $message->files = $this->saveFilesWithName([file_get_contents($request->message['message']->media)], 'chat', 'file', $message->id);

            $message->save();
        }

        event(new NewMessage($chat->users()->where('id', '!=', $crmConnection->user_id)->first(), $message));

        return 'OK';
    }
}
