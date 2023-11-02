<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Chat::class);

        $paginationPerPage = $request['p'] ?? 15;
        if ($paginationPerPage >= 1000){
            return response()->json(['message' => "1000+ is to much pagnation"]);
        }
        $chat = Chat::with('chatRoom')->with('messages')->paginate($paginationPerPage);

        return response()->json(['object' => $chat]);
    }

    public function deleted(Request $request)
    {
        $this->authorize('viewAny_deleted',Chat::class);

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
        $user = auth('sanctum')->user();
        $this->authorize('create', [Chat::class, $user]);

        $request->validated();
        $chatExists = Chat::withTrashed()->firstWhere('name','=', $request['name']);

        if (!empty($chatExists))
        {
            if ($chatExists->trashed())
            {
                $chatExists->restore();
                return response()->json(['message' => "The chat already exists but was deleted and have been restored"],201);
            }
            return response()->json(['message' => "The chat already exists"],400);
        }

        $chat = new Chat();
        $chat['name'] = $request['name'];
        $chat->chatRoom()->associate($request['chatRoom']);
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
        $user = auth('sanctum')->user();
        $this->authorize('view', [Chat::class, $user]);

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

        $this->authorize('create', [$object, User::class]);
        $chatExits = Chat::withTrashed()->firstWhere('name','=', $request['name']);

        if (!empty($chatExits) && $chatExits['id'] != $object['id'])
        {
            return response()->json(['message' => "Can't change the chat name to one that already exists"],400);
        }
        else
        {
            if ($object['name'] != $request['name'])
            {
                $object['name'] = $request['name'];
            }
            $object->chatRoom()->associate($request['chatRoom']);

            $object->save();
        }

        return response()->json(['message' => "successfully updated the chat", 'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $chat)
    {
        $user = auth('sanctum')->user();
        $this->authorize('delete', [Chat::class, $user]);

        $object = Chat::withTrashed()->firstWhere('id','=', $chat);
        $object->delete();

        return response()->json(['message' => "deleted the chat successfully"]);
    }

    public function restore(string $chat)
    {
        $user = auth('sanctum')->user();
        $this->authorize('restore', [Chat::class, $user]);

        $object = Chat::onlyTrashed()->firstWhere('id','=', $chat);
        $object->restore();
        $object->messages;
        $object->chatRoom;

        return response()->json(['message' => "Restored the chat",'object' => $object],201);
    }

    public function forceDelete(string $chat)
    {
        $user = auth('sanctum')->user();
        $this->authorize('forceDelete', [Chat::class, $user]);

        $object = Chat::onlyTrashed()->firstWhere('id','=', $chat);
        $object->forceDelete();

        return response()->json(['message' => "Chat Deleted completely"]);
    }
}
