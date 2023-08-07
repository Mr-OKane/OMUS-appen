<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Models\Permission;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'notification.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return NotificationResource::collection(Notification::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNotificationRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreNotificationRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'notification.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
        $notification = new Notification();

        $this->validate($request,[
            'message' => 'required|string|max:255',
        ]);
        $notification->message = $request->message;
        $notification->save();

        return response()->json(['message' => 'created the notification', 'object' => $notification]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Notification $notification)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'notification.view'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return NotificationResource::collection(Notification::findOrFail($notification));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotificationRequest  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'notification.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');
        $object = Notification::withTrashed()->where('id','=',$notification)->first();
        $this->validate($request,[
            'message' => 'required|string|max:255',
        ]);

        if ($object->message != $request->message){
            $object->message = $request->message;
        }
        $object->save();

        return response()->json(['message' => 'updated the notification'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Notification $notification)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'notification.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Notification::withTrashed()->where('id','=',$notification)->first();
        $object->delete();
        return response()->json(['message' => 'deleted the notification','object' => $object]);
    }
}
