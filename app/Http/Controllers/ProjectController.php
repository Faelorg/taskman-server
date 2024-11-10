<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use  Illuminate\Support\Str;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(){
        $this->middleware(['auth:api']);
    }


    public function createProject($id_company){
        $user = auth()->user();
        if($user->is_admin){
            $id_project = Str::uuid();
            $project = new Project();
            $project->id_project = $id_project;
            $project->name = request('name');
            $project->description = request('description');
            $project->id_status = 1;
            $project->id_company = $id_company;
            $project->save();

            $id_role = Str::uuid();
            $role = new Role();
            $role->id_role = $id_role;
            $role->name = 'Администратор';
            $role->description = 'Роль с полным доступом';
            $role->close_project = true;
            $role->update_project = true;
            $role->create_column = true;
            $role->update_column = true;
            $role->delete_column = true;
            $role->create_task = true;
            $role->update_task = true;
            $role->delete_task = true;
            $role->id_project = $id_project;
            $role->save();

            $roleuser = new RoleUser();
            $roleuser->id_user = $user->id_user;
            $roleuser->id_role = $id_role;
            $roleuser->id_project = $id_project;
            $roleuser->save();
            return;
        }

        return response()->json(["text"=>'access denied'], 403);
    }

    public function getAllProject($id_company) {
        auth()->user();

        return Project::where(['id_status'=>'1','id_company'=>$id_company])->get();
    }

    public function getAllCloseProject($id_company) {
        auth()->user();

        return Project::where(['id_status'=>'2','id_company'=>$id_company])->get();
    }

    public function getByIdProject($id_company,$id_project) {
        auth()->user();
        return Project::where(['id_project'=>$id_project,'id_company'=>$id_company])->firstOrFail();
    }

    public function updateProject($id_company,$id_project) {
        $user = auth()->user();
        $role = $user->getRoleProject($id_project);
        if($role){
            if(!$role->update_project){
                $project = Project::where(['id_project'=>$id_project,'id_company'=>$id_company])->firstOrFail();
                $project->name = request('name');
                $project->description = request('description');
                $project->id_status = request('id_status');
                $project->save();
                return;
            }
        }

        return response()->json(["text"=>'access denied'], 403);
    }

    public function closeProject($id_company,$id_project){
        $user = auth()->user();
        $role = $user->getRoleProject($id_project);
        if($role){
            if($role->close_project){
                $project = Project::where(['id_project'=>$id_project,'id_company'=>$id_company])->firstOrFail();
                $project->id_status = 2;
                $project->save();
                return;
            }
        }

        return response()->json(["text"=>'access denied'], 403);
    }
}
