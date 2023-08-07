<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatRoomResource;
use App\Http\Resources\IdeaResource;
use App\Models\ChatRoom;
use App\Http\Requests\StoreChatRoomRequest;
use App\Http\Requests\UpdateChatRoomRequest;
use App\Models\Permission;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ChatRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'chatroom.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return ChatRoomResource::collection(ChatRoom::all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletedChatRooms()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'chatroom.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $deletedChatRooms = ChatRoom::onlyTrashed();
        return response()->json($deletedChatRooms,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreChatRoomRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreChatRoomRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'chatroom.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
        $chatroom = new ChatRoom();
        $this->validate($request,[
            'name' => 'required|string|max:255',
        ]);
        $chatroom->name = $request['name'];
        $chatroom->save();

        return response()->json(['message' => 'Created the chat room', 'object' => $chatroom],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(ChatRoom $chatRoom)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'chatroom.view'))
            ? Response::allow()
            : Response::deny('You are not the chosen one');

        return ChatRoomResource::collection(ChatRoom::findOrFail($chatRoom));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChatRoomRequest  $request
     * @param  \App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateChatRoomRequest $request, ChatRoom $chatRoom)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'chatroom.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
        $object = ChatRoom::withTrashed()->where('id', '=', $chatRoom)->first();

        $this->validate($request,[
           'name' => 'required|string|max:255',
        ]);
        if ($object->name != $request->name){
            $object->name = $request->name;
        }
        $object->save();

        return response()->json(['message' => 'Updated the chat room', 'object' => $object],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(ChatRoom $chatRoom)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'chatroom.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = ChatRoom::withTrashed()->where('id', '=', $chatRoom)->first();
        $object->delete();

        return response()->json(['message' => '', 'object' => $object],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(ChatRoom $chatRoom)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'chatroom.delete.force'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = ChatRoom::withTrashed()->where('id', '=', $chatRoom)->first();
        $object->forceDelete();

        return response()->json(['message' => 'deleted the chat room completely', 'object' => $chatRoom],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChatRoom  $chatRoom
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(ChatRoom $chatRoom)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'chatroom.restore'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = ChatRoom::withTrashed()->where('id', '=', $chatRoom)->first();
        $object->restore();

        return response()->json(['message' => 'restored the chatroom', 'object' => $object],200);
    }
}
