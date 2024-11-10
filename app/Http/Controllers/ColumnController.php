<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Column;
use  Illuminate\Support\Str;

class ColumnController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }
    public function getAll($id_company, $id_project) {
        $user = auth()->user();
        Project::where(['id_company'=>$id_company,'id_project'=>$id_project])->firstOrFail();
        return $column = Column::where(['id_project'=>$id_project])->get();
    }

    public function getById($id_company, $id_project,$id_column) {
        $user = auth()->user();
        Project::where(['id_company'=>$id_company,'id_project'=>$id_project])->firstOrFail();
        return $column = Column::where(['id_project'=>$id_project,'id_column'=>$id_column])->firstOrFail();
    }

    public function create($id_company, $id_project) {
        $user = auth()->user();
        $role = $user->getRoleProject($id_project);
        if ($role) {
            if ($role->create_column) {
                Project::where(['id_company'=>$id_company,'id_project'=>$id_project])->firstOrFail();
                $column = new Column();
                $column->name = request('name');
                $column->description = request('description');
                $column->color = request('color');
                $column->id_project = request('id_project');
                $column->save();
            }
        }

    }

    public function update($id_company, $id_project,$id_column) {
        $user = auth()->user();
        if ($role = $user->getRoleProject($id_project)) {
            if ($role->update_column) {
                Project::where(['id_company'=>$id_company,'id_project'=>$id_project])->firstOrFail();
                $column = Column::findOrFail($id_column);
                $column->name = request('name');
                $column->description = request('description');
                $column->color = request('color');
                $column->id_project = request('id_project');
                $column->save();
            }
        }
    }

    public function delete($id_company, $id_project,$id_column) {
        $user = auth()->user();
        if ($role = $user->getRoleProject($id_project)) {
            if ($role->delete_column) {
                Project::where(['id_company'=>$id_company,'id_project'=>$id_project])->firstOrFail();
                $column = Column::findOrFail($id_column);
                $column->delete();
            }
        }
    }
}
