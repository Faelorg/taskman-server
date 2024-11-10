<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use  Illuminate\Support\Str;

class RoleController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function GetRole($id_company,$id_project) {
        $user = auth()->user();
        $project = Project::where(['id_project'=>$id_project,'id_company'=>$id_company])->firstOrFail();
        return Role::where(['id_project'=>$id_project])->get();
    }

    public function GetRoleById($id_company,$id_project,$id_role) {
        $user = auth()->user();
        $project = Project::where(['id_project'=>$id_project,'id_company'=>$id_company])->firstOrFail();
        return Role::where(['id_project'=>$id_project,'id_role'=>$id_role])->firstOrFail();
    }

    public function CreateRole($id_company,$id_project){
        $user = auth()->user();
        if($user->is_admin){
            $project = Project::where(['id_project'=>$id_project,'id_company'=>$id_company])->firstOrFail();
            $role = new Role();
            $id = Str::uuid();

            $role->id_role = $id;
            $role->name = request('name');
            $role->description = request('description');
            $role->close_project = request('close_project');
            $role->update_project = request('update_project');
            $role->create_column = request('create_column');
            $role->update_column = request('update_column');
            $role->delete_column = request('delete_column');
            $role->create_task = request('create_task');
            $role->update_task = request('update_task');
            $role->delete_task = request('delete_task');
            $role->id_project = $id_project;
            $role->save();
        }
    }

    public function UpdateRole($id_company,$id_project,$id_role){
        $user = auth()->user();
        if($user->is_admin){
            $project = Project::where(['id_project'=>$id_project,'id_company'=>$id_company])->firstOrFail();
            $role = Role::Where(['id_project'=>$id_project,'id_role'=>$id_role])->firstOrFail();

            $role->name = request('name');
            $role->description = request('description');
            $role->close_project = request('close_project');
            $role->update_project = request('update_project');
            $role->create_column = request('create_column');
            $role->update_column = request('update_column');
            $role->delete_column = request('delete_column');
            $role->create_task = request('create_task');
            $role->update_task = request('update_task');
            $role->delete_task = request('delete_task');
            $role->id_project = $id_project;
            $role->save();
        }
    }

    public function DeleteRole($id_company,$id_project,$id_role){
        $user = auth()->user();
        if($user->is_admin){
            $project = Project::where(['id_project'=>$id_project,'id_company'=>$id_company])->firstOrFail();
            $role = Role::Where(['id_project'=>$id_project,'id_role'=>$id_role])->firstOrFail();
            $role->delete();
        }
    }

    public function getAllUserFromRole($id_company,$id_project,$id_role){
        $user = auth()->user();
        if($user->is_admin){
            $project=Project::where(['id_project'=>$id_project,'id_company'=>$id_company])->firstOrFail();
            $role = Role::Where(['id_project'=>$id_project,'id_role'=>$id_role])->firstOrFail();

            $roleusers = RoleUser::where(['id_role'=>$id_role,'id_project'=>$id_project])->get();
            $users = [];
            foreach ($roleusers as $roleuser) {
                $users []=User::findOrFail($roleuser->id_user);
            }

            return $users;
        }
    }

    public function SetUserRole($id_company,$id_project,$id_role) {
        $user = auth()->user();
        if (RoleUser::where(['id_user'=>request('id_user')])->first()) {
            return response()->json(['error' => 'Пользователь в роли'], 403);
        }
        if($user->is_admin){
            $project=Project::where(['id_project'=>$id_project,'id_company'=>$id_company])->firstOrFail();
            $role = Role::Where(['id_project'=>$id_project,'id_role'=>$id_role])->firstOrFail();

            $roleuser = new RoleUser();
            $roleuser->id_user = request('id_user');
            $roleuser->id_role = $id_role;
            $roleuser->id_project = $id_project;
            $roleuser->save();
        }
    }

    public function RemoveUserRole($id_company,$id_project,$id_role) {
        $user = auth()->user();
        if($user->is_admin){
            $project=Project::where(['id_project'=>$id_project,'id_company'=>$id_company])->firstOrFail();
            $role = Role::Where(['id_project'=>$id_project,'id_role'=>$id_role])->firstOrFail();
            $id_user = request('id_user');
            $roleuser = RoleUser::where(['id_role'=>$id_role,'id_project'=>$id_project,'id_user'=>$id_user])->firstOrFail();
            $roleuser->delete();
        }
    }

    public function GetRoleFromUser($id_company,$id_project){
        $user = auth()->user();
        $project=Project::where(['id_project'=>$id_project,'id_company'=>$id_company])->firstOrFail();
        return $user->getRoleProject($id_project);
    }
}
