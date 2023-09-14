<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use App\Http\Requests\StoreChatRoomRequest;
use App\Http\Requests\UpdateChatRoomRequest;
use Illuminate\Http\Request;
use newrelic\DistributedTracePayload;

class ChatRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000){
            return response()->json(['message' => "1000+ pagnation per page is to much"]);
        }

        $chatRoom = ChatRoom::withTrashed()->with('chats')->paginate($paginationPerPage);

        return response()->json(['object' => $chatRoom]);
    }

    public function deleted(Request $request)
    {
        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ chatRooms per page is to much at a time"],400);
        }
        $chatRooms = ChatRoom::onlyTrashed()->with('chats')->paginate($paginationPerPage);

        return response()->json(['message' => "Deleted chat rooms", 'object' => $chatRooms]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChatRoomRequest $request)
    {
        $request->validated();

        $chatRoom = new ChatRoom();
        $chatRoom['name'] = $request['name'];
        $chatRoom->save();

        $object = ChatRoom::withTrashed()->firstWhere('id','=',$chatRoom['id']);
        $object->chats;

        return response()->json(['message' => "created the chat room  successfully", 'object' => $object],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $chatRoom)
    {
        $object = ChatRoom::withTrashed()->firstWhere('id','=',$chatRoom);
        $object->chats;

        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChatRoomRequest $request, string $chatRoom)
    {
        $request->validated();

        $object = ChatRoom::withTrashed()->firstWhere('id','=',$chatRoom);
        if ($object['name'] != $request['name'])
        {
            $object['name'] = $request['name'];
        }

        $object->save();

        return response()->json(['message' => "updated the chat room successfully",'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $chatRoom)
    {
        $object = ChatRoom::withTrashed()->firstWhere('id','=', $chatRoom);
        $object->delete();
        return response()->json(['message' => "deleted the chat room successfully"]);
    }

    public function restore(string $chatRoom)
    {
        $object = ChatRoom::onlyTrashed()->firstWhere('id','=', $chatRoom);
        $object->restore();
        $object->chats;

        return response(['message' => "restored the chatRoom", 'object' => $object],201);
    }

    public function forceDelete(string $chatRoom)
    {
        $object = ChatRoom::onlyTrashed()->firstWhere('id','=', $chatRoom);
        $object->forceDelete();

        return response()->json(['message' => "Deleted the chatRoom completely"]);
    }
}
