<?php

namespace App\Http\Controllers;


use App\Http\Resources\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'role.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return RoleResource::collection(Role::all());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletedRoles()
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'role.deleted.viewAny'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $roles = Role::onlyTrashed();
        return response()->json($roles,200);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Role $role)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'role.view'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        return RoleResource::collection(Role::findOrFail($role));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoleRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRoleRequest $request)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'role.create'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $this->validate($request,[
            'name' => 'required|string|max:255'
        ]);

        $search = Role::where('name','=',$request['name']);
        if (!empty($search)){
            return response()->json(['message' => 'the role allready exists'],400);
        }

        $role = new Role();
        $role->name = $request['name'];
        $role->save();
        return response()->json(['message' => 'created role successfully','object' => $role],201);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'role.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        if ($request['name'] === "administrator"){
            return response()->json("can not update administrator role",400);
        }
        if (!empty($request)){
            $this->validate($request,[
                'name' => 'required|string|max:255'
            ]);
            $role->name = $request['name'];
        }
        $role->save();
        return response()->json(['message' => 'updated the roles name successfully','object' => $role],200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function rolePermissionUpdate(UpdateRoleRequest $request, Role $role)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'role.permission.update'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        if (Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'role.update'))){
            $permissionIDs = [];
            if (!empty($request['absence_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','absence.viewAny')->id
                );
            }

            if (!empty($request['absence_view'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','absence.view')->id
                );
            }

            if (!empty($request['absence_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','absence.update')->id
                );
            }

            if (!empty($request['absence_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','absence.delete')->id
                );
            }

            if (!empty($request['address_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','address.viewAny')->id
                );
            }

            if (!empty($request['address_view'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','address.view')->id
                );
            }

            if (!empty($request['address_create'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','address.create')->id
                );
            }

            if (!empty($request['address_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','address.update')->id
                );
            }

            if (!empty($request['address_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','address.delete')->id
                );
            }

            if (!empty($request['chat_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','chat.viewAny')->id
                );
            }

            if (!empty($request['chat_viewAny_deleted'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','chat.deleted.viewAny')->id
                );
            }

            if (!empty($request['chat_view'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','chat.view')->id
                );
            }

            if (!empty($request['chat_create'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','chat.create')->id
                );
            }

            if (!empty($request['chat_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','chat.update')->id
                );
            }

            if (!empty($request['chat_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','chat.delete')->id
                );
            }

            if (!empty($request['chat_force_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','chat.delete.force')->id
                );
            }

            if (!empty($request['chat_restore'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','chat.restore')->id
                );
            }

            if (!empty($request['chatroom_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','chatroom.viewAny')->id
                );
            }

            if (!empty($request['chatroom_viewAny_deleted'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','chatroom.deleted.viewAny')->id
                );
            }

            if (!empty($request['chatroom_view'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','chatroom.view')->id
                );
            }

            if (!empty($request['chatroom_create'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','chatroom.create')->id
                );
            }

            if (!empty($request['chatroom_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','chatroom.update')->id
                );
            }

            if (!empty($request['chatroom_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','chatroom.delete')->id
                );
            }

            if (!empty($request['chatroom_force_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','chatroom.delete.force')->id
                );
            }

            if (!empty($request['chatroom_restore'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','chatroom.restore')->id
                );
            }

            if (!empty($request['idea_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','idea.viewAny')->id
                );
            }

            if (!empty($request['idea_view'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','idea.view')->id
                );
            }

            if (!empty($request['idea_create'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','idea.create')->id
                );
            }

            if (!empty($request['idea_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','idea.update')->id
                );
            }

            if (!empty($request['idea_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','idea.delete')->id
                );
            }

            if (!empty($request['instrument_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','instrument.viewAny')->id
                );
            }

            if (!empty($request['instrument_viewAny_deleted'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','instrument.deleted.viewAny')->id
                );
            }

            if (!empty($request['instrument_view'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','instrument.view')->id
                );
            }

            if (!empty($request['instrument_create'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','instrument.create')->id
                );
            }

            if (!empty($request['instrument_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','instrument.update')->id
                );
            }

            if (!empty($request['instrument_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','instrument.delete')->id
                );
            }

            if (!empty($request['instrument_force_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','instrument.delete.force')->id
                );
            }

            if (!empty($request['instrument_restore'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','instrument.restore')->id
                );
            }

            if (!empty($request['message_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','message.viewAny')->id
                );
            }

            if (!empty($request['message_view'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','message.view')->id
                );
            }

            if (!empty($request['message_create'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','message.create')->id
                );
            }

            if (!empty($request['message_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','message.update')->id
                );
            }

            if (!empty($request['message_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','message.delete')->id
                );
            }

            if (!empty($request['notification_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','notification.viewAny')->id
                );
            }

            if (!empty($request['notification_view'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','notification.view')->id
                );
            }

            if (!empty($request['notification_create'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','notification.create')->id
                );
            }

            if (!empty($request['notification_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','notification.update')->id
                );
            }

            if (!empty($request['notification_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','notification.delete')->id
                );
            }

            if (!empty($request['order_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','order.viewAny')->id
                );
            }

            if (!empty($request['order_viewAny_deleted'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','order.deleted.viewAny')->id
                );
            }

            if (!empty($request['order_view'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','order.view')->id
                );
            }

            if (!empty($request['order_create'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','order.create')->id
                );
            }

            if (!empty($request['order_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','order.update')->id
                );
            }

            if (!empty($request['order_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','order.delete')->id
                );
            }

            if (!empty($request['order_force_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','order.delete.force')->id
                );
            }

            if (!empty($request['order_restore'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','order.restore')->id
                );
            }

            if (!empty($request['orderstatus_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','orderstatus.viewAny')->id
                );
            }

            if (!empty($request['orderstatus_view'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','orderstatus.view')->id
                );
            }

            if (!empty($request['orderstatus_create'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','orderstatus.create')->id
                );
            }

            if (!empty($request['orderstatus_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','orderstatus.update')->id
                );
            }

            if (!empty($request['orderstatus_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','orderstatus.delete')->id
                );
            }

            if (!empty($request['permission_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','permission.viewAny')->id
                );
            }

            if (!empty($request['postalcode_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','postalcode.viewAny')->id
                );
            }

            if (!empty($request['postalcode_view'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','postalcode.view')->id
                );
            }

            if (!empty($request['practicedate_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','practicedate.viewAny')->id
                );
            }

            if (!empty($request['practicedate_viewAny_deleted'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','practicedate.deleted.viewAny')->id
                );
            }

            if (!empty($request['practicedate_view'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','practicedate.view')->id
                );
            }

            if (!empty($request['practicedate_create'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','practicedate.create')->id
                );
            }

            if (!empty($request['practicedate_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','practicedate.update')->id
                );
            }

            if (!empty($request['practicedate_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','practicedate.delete')->id
                );
            }

            if (!empty($request['product_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','product.viewAny')->id
                );
            }

            if (!empty($request['product_viewAny_deleted'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','product.deleted.viewAny')->id
                );
            }

            if (!empty($request['product_view'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','product.view')->id
                );
            }

            if (!empty($request['product_create'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','product.create')->id
                );
            }

            if (!empty($request['product_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','product.update')->id
                );
            }

            if (!empty($request['product_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','product.delete')->id
                );
            }

            if (!empty($request['product_force_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','product.delete.force')->id
                );
            }

            if (!empty($request['product_restore'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','product.restore')->id
                );
            }

            if (!empty($request['role_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','role.viewAny')->id
                );
            }

            if (!empty($request['role_viewAny_deleted'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','role.deleted.viewAny')->id
                );
            }

            if (!empty($request['role_permission_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','role.permission.viewAny')->id
                );
            }

            if (!empty($request['role_view'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','role.view')->id
                );
            }

            if (!empty($request['role_create'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','role.create')->id
                );
            }

            if (!empty($request['role_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','role.update')->id
                );
            }

            if (!empty($request['role_permission_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','role.permission.update')->id
                );
            }

            if (!empty($request['role_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','role.delete')->id
                );
            }

            if (!empty($request['role_force_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','role.delete.force')->id
                );
            }

            if (!empty($request['role_restore'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','role.restore')->id
                );
            }

            if (!empty($request['sheet_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','sheet.viewAny')->id
                );
            }

            if (!empty($request['sheet_viewAny_deleted'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','sheet.deleted.viewAny')->id
                );
            }

            if (!empty($request['sheet_view'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','sheet.view')->id
                );
            }

            if (!empty($request['sheet_create'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','sheet.create')->id
                );
            }

            if (!empty($request['sheet_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','sheet.delete')->id
                );
            }

            if (!empty($request['sheet_force_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','sheet.delete.force')->id
                );
            }

            if (!empty($request['sheet_restore'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','sheet.restore')->id
                );
            }

            if (!empty($request['team_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','team.viewAny')->id
                );
            }

            if (!empty($request['team_viewAny_deleted'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','team.deleted.viewAny')->id
                );
            }

            if (!empty($request['team_user_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','team.user.viewAny')->id
                );
            }

            if (!empty($request['team_view'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','team.view')->id
                );
            }

            if (!empty($request['team_create'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','team.create')->id
                );
            }

            if (!empty($request['team_user_create'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','team.user.create')->id
                );
            }

            if (!empty($request['team_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','team.update')->id
                );
            }

            if (!empty($request['team_user_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','team.user.update')->id
                );
            }

            if (!empty($request['team_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','team.delete')->id
                );
            }

            if (!empty($request['team_force_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','team.delete.force')->id
                );
            }

            if (!empty($request['team_restore'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','team.restore')->id
                );
            }

            if (!empty($request['user_viewAny'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','user.viewAny')->id
                );
            }

            if (!empty($request['user_viewAny_deleted'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','user.deleted.viewAny')->id
                );
            }

            if (!empty($request['user_view'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','user.view')->id
                );
            }

            if (!empty($request['user_create'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','user.create')->id
                );
            }

            if (!empty($request['user_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','user.update')->id
                );
            }

            if (!empty($request['user_role_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','user.role.update')->id
                );
            }

            if (!empty($request['user_instrument_update'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','user.instrument.update')->id
                );
            }

            if (!empty($request['user_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','user.delete')->id
                );
            }

            if (!empty($request['user_force_delete'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','user.delete.force')->id
                );
            }

            if (!empty($request['user_restore'])){
                array_push($permissionIDs,
                    Permission::firstWhere('name','=','user.restore')->id
                );
            }
            $role->permissions()->sync($permissionIDs);
        }

        return response()->json(['message' => 'updated the permissions var successfully added to the role','object' => $role],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'role.delete'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Role::withTrashed()->where('id','=',$role)->first();
        $object->delete();
        return response()->json(['message' => 'deleted the role','object' => $object],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete(Role $role)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'role.delete.force'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Role::withTrashed()->where('id','=',$role);
        $object->forceDelete();
        return response()->json(['message' => 'deleted the role for good', 'object' => $object]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Role $role)
    {
        Auth::user()->role->permissions->contains(Permission::firstWhere('name', '=', 'role.restore'))
            ? Response::allow()
            : Response::deny('you are not the chosen one');

        $object = Role::withTrashed()->where('id','=',$role);
        $object->restore();
        return response()->json(['message' => 'restored the role', 'object' => $object]);

    }
}
