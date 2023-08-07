<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatResource;
use App\Models\Chat;
use App\Http\Requests\StoreChatRequest;
use App\Http\Requests\UpdateChatRequest;
use App\Models\ChatRoom;
use App\Models\Permission;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'chat.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return ChatResource::collection(Chat::all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletedChats()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'chat.deleted.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $deletedChats = Chat::onlyTrashed();
        return response()->json($deletedChats,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreChatRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreChatRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'chat.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $chat = new Chat();
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'chatroom' => 'required|integer|digits_between:1,20'
        ]);
        $chat->name = $request->name;
        $chat->chatRoom()->associate(ChatRoom::firstWhere('id', '=', $request["chatroom"])->ids);
        $chat->save();
        return response()->json(['message' => 'created the chat', 'object' => $chat],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Chat $chat)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'chat.view'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return ChatResource::collection(Chat::findOrFail($chat));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateChatRequest  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChatRequest $request, Chat $chat)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'chat.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
        $object = Chat::withTrashed()->where('id', '=', $chat)->first();

        $this->validate($request,[
            'name' => 'required|string|max:255',
        ]);

        if ($object->name != $request->name){
            $object->name = $request->name;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Chat $chat)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'chat.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Chat::withTrashed()->where('id', '=',$chat)->first();
        $object->delete();
        return response()->json(['message' => 'deleted the chat', 'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(Chat $chat)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'chat.delete.force'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Chat::withTrashed()->where('id', '=', $chat)->first();
        $object->forceDelete();
        return response()->json(['message' => 'Deleted the chat completely', 'object' => $object],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Chat $chat)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'chat.restore'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Chat::withTrashed()->where('id', '=', $chat)->first();
        $object->restore();
        return response()->json(['message' => 'restored the chat', 'object' => $object]);
    }
}
