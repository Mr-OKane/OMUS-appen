<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginationPerPage = $request['p'] ?? 15;
        if ($paginationPerPage >= 1000){
            return response()->json(['message' => "1000+ is to much pagnation"]);
        }
        $chat = Chat::with('chatRoom')->with('messages')->paginate($paginationPerPage);

        return response()->json(['object' => $chat]);
    }

    public function deleted(Request $request)
    {
        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ chats is to much at a time"],400);
        }
        $chats = Chat::onlyTrashed()->with('chatRoom')->with('messsages')->paginate($paginationPerPage);

        response()->json(['message' => "deleted chats", 'object' => $chats]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatRequest $request)
    {
        $request->validated();

        $chat = new Chat();
        $chat['name'] = $request['name'];
        $chat->chatRoom()->associate($request['chatroom']);
        $chat->save();

        $object = Chat::withTrashed()->firstWhere('id','=', $chat['id']);
        $object->chatRoom;

        return response()->json(['message' => "created the chat successfully",'object' => $object],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $chat)
    {
        $object = Chat::withTrashed()->firstWhere('id','=', $chat);
        $object->chatRoom;
        $object->messages;

        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChatRequest $request, string $chat)
    {
        $request->validated();

        $object = Chat::withTrashed()->firstWhere('id','=', $chat);
        if ($object['name'] != $request['name'])
        {
            $object['name'] = $request['name'];
        }
        $object->chatRoom()->associate($request['chatRoom']);

        $object->save();
        return response()->json(['message' => "successfully updated the chat", 'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $chat)
    {
        $object = Chat::withTrashed()->firstWhere('id','=', $chat);
        $object->delete();

        return response()->json(['message' => "deleted the chat successfully"]);
    }

    public function restore(string $chat)
    {
        $object = Chat::onlyTrashed()->firstWhere('id','=', $chat);
        $object->restore();
        $object->messages;
        $object->chatRoom;

        return response()->json(['message' => "Restored the chat",'object' => $object],201);
    }

    public function forceDelete(string $chat)
    {
        $object = Chat::onlyTrashed()->firstWhere('id','=', $chat);
        $object->forceDelete();

        return response()->json(['message' => "Chat Deleted completely"]);
    }
}
