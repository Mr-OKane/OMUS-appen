<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ messages per page is 2 much"],400);
        }

        return response()->json();
    }
    public function chatMessages(string $chat)
    {

        $messages = Message::all()->where('chat_id','=', $chat);
        return response()->json(['object' => $messages]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request)
    {
        $user = auth('sanctum')->user();
        $request->validated();

        $message = new Message();
        $message['message'] = $request['message'];
        $message->chat()->associate($request['chat']);
        $message->user()->associate($user['id']);
        $message->save();

        $object = Message::withTrashed()->firstWhere('id','=', $message['id']);
        $object->chat;

        return response()->json(['message' => "created message successfully",'object' => $object],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $message)
    {
        $object = Message::withTrashed()->firstWhere('id','=', $message);
        $object->chat;
        $object->user;

        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, string $message)
    {
        $request->validated();

        $object = Message::withTrashed()->firstWhere('id','=', $message);

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
        $object = Message::withTrashed()->firstWhere('id','=', $message);
        $object->delete();
        return response()->json(['message' => "deleted the message sucessfully."]);
    }
}
