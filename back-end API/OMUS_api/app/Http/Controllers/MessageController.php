<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
    }

    public function chatMessages(Request $request, string $chat)
    {
        $this->authorize('viewAny',Message::class);

        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ messages per page is 2 much"],400);
        }

        $messages = Message::with('user')->with('chat.chatRoom')->where('chat_id','=', $chat)
        ->paginate($paginationPerPage);
        return response()->json(['object' => $messages]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request)
    {
        $user = auth('sanctum')->user();
        $this->authorize('create', [Message::class,$user]);

        $request->validated();

        $message = new Message();
        $message['message'] = $request['message'];
        $message->chat()->associate($request['chat']);
        $message->user()->associate($user['id']);
        $message->save();

        $object = Message::where('id','=', $message['id'])->first;
        $object->chat;

        return response()->json(['message' => "created message successfully",'object' => $object],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $message)
    {
        $user = \auth('sanctum')->user();
        $this->authorize('view', [Message::class,$user]);
        $object = Message::where('id','=', $message)->first();
        $object->chat;
        $object->user;

        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, string $message)
    {
        $object = Message::where('id','=', $message)->first();

        $this->authorize('update', [$object, User::class]);

        $request->validated();

        if ($object['message'] != $request['message'])
        {
            $object['message'] = $request['message'];
        }
        $object->save();

        return response()->json(['message' => "edited",'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $message)
    {
        $user = \auth('sanctum')->user();
        $this->authorize('delete', [Message::class,$user]);

        $object = Message::where('id','=', $message)->first();
        $object->delete();
        return response()->json(['message' => "deleted the message sucessfully."]);
    }
}
