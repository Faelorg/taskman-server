<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Column;
use App\Models\Company;
use App\Models\Task;
use  Illuminate\Support\Str;

class TaskController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }

    public function getAll($id_company, $id_project, $id_column) {
        $user = auth()->user();
        Project::where(['id_company'=>$id_company,'id_project'=>$id_project])->firstOrFail();
        return Task::where(['id_column'=>$id_column])->get();
    }

    public function getById($id_company, $id_project, $id_column, $id_task){
        $user = auth()->user();
        Project::where(['id_company'=>$id_company,'id_project'=>$id_project])->firstOrFail();
        return Task::where(['id_column'=>$id_column,'id_task'=>$id_task])->firstOrFail();
    }

    public function create($id_company, $id_project, $id_column) {
        $user = auth()->user();
        $role = $user->getRoleProject($id_project);
        if($role){
            if($role->create_task){
                Project::where(['id_company'=>$id_company,'id_project'=>$id_project])->firstOrFail();
                $company = Company::find($id_company);
                $task = new Task();
                $task->id_task = Str::uuid();
                $task->name = request('name');
                $task->description = request('description');
                $task->code = $company->codetask."-".random_int(100000, 999999);
                $task->status=1;
                $task->id_column=$id_column;
                $task->save();
            }
        }
    }

    public function update($id_company, $id_project, $id_column, $id_task) {
        $user = auth()->user();
        $role = $user->getRoleProject($id_project);
        if($role){
            if($role->update_task){
                Project::where(['id_company'=>$id_company,'id_project'=>$id_project])->firstOrFail();
                $company = Company::findOrFail($id_company);
                $task = Task::findOrFail($id_task);
                $task->name = request('name');
                $task->description = request('description');
                $task->code = $company->codetask."-".random_int(100000, 999999);
                $task->status=request('status');
                $task->id_user = request('id_user');
                $task->id_column = request('id_column');
                $task->save();
            }
        }
    }
}
