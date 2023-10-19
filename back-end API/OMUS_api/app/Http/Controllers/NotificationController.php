<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny',Notification::class);

        $paginationPerPage = $request->input('p') ?? 15;
        if ($paginationPerPage >= 1000)
        {
            return response()->json(['message' => "1000+ pagination per page to much"],400);
        }

        $notifications = Notification::paginate($paginationPerPage);

        return response()->json(['object' => $notifications]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotificationRequest $request)
    {
        $user = auth('sanctum')->user();
        $this->authorize('create', [Notification::class, $user]);

        $request->validated();

        $notificationExists = Notification::withTrashed()->firstWhere('message','=', $request['message']);
        if (!empty($notificationExists))
        {
            if ($notificationExists->trashed())
            {
                $notificationExists->restore();
                return response()->json(['message' => "The notification exists but was deleted and now it is restored"],201);
            }
            return response()->json(['message' => "notification already exists"],400);

        }
        $notification = new Notification();
        $notification['message'] = $request['message'];
        $notification->save();

        return response()->json(['message' => "Created the notification successfully",'object' => $notification],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $notification)
    {
        $user = auth('sanctum')->user();
        $this->authorize('view', [Notification::class, $user]);

        $object = Notification::withTrashed()->firstWhere('id','=', $notification);
        return response()->json(['object' => $object]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotificationRequest $request, string $notification)
    {
        $object = Notification::withTrashed()->firstWhere('id','=', $notification);

        $this->authorize('update', [$object, User::class]);

        $request->validated();

        $notificationExists = Notification::withTrashed()->firstWhere('message','=', $request['message']);
        if (!empty($notificationExists) && $notificationExists['id'] != $object['id'])
        {
            return response()->json(["can't change a Notification to one that exists"],400);
        }
        if ($object['message'] != $request['message'])
        {
            $object['message'] = $request['message'];
        }
        $object->save();

        return response()->json(['message' => "Updated the notification successfully", 'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $notification)
    {
        $user = auth('sanctum')->user();
        $this->authorize('delete', [Notification::class, $user]);

        $object = Notification::withTrashed()->firstWhere('id','=', $notification);
        $object->delete();
        return response(['message' => "deleted the notification"]);
    }
}
