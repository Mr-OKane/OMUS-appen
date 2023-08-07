<?php

namespace App\Http\Controllers;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'message.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return MessageResource::collection(Message::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMessageRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreMessageRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'message.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $message = new Message();
        $this->validate($request,[
            'message' => 'required|string|max:255',
            'user' => 'required|integer|digits_between:1,20'
        ]);

        $message->message = $request->message;
        $message->user()->associate(User::firstWhere('id','=',$request['userID']));
        $message->save();

        return response()->json(['message' => 'message created', 'object' => $message],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Message $message)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'message.view'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return MessageResource::collection(Message::findOrFail($message));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMessageRequest  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'message.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Message::withTrashed()->where('id','=',$message)->first();
        $this->validate($request,[
            'message' => 'required|string|max:255'
        ]);

        if ($object->message != $request->message){
            $object->message = $request->message;
        }
        $object->save();

        return response()->json(['message' => 'updated message','object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Message $message)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'message.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Message::withTrashed()->where('id','=',$message)->first();
        $object->delete();
        return response()->json(['message' => 'deleted the message', 'object' => $object],200);
    }
}
