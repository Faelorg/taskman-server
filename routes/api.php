<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [UserController::class,'login'])->name('login');
    Route::post('reg', [UserController::class,'registration']);
    Route::get('logout', [UserController::class,'logout']);
    Route::get('profile', [UserController::class,'getProfile']);
    Route::get('company', [UserController::class,'getCompany']);
    Route::post('invite', [UserController::class,'inviteUser']);
    Route::post('restore', [UserController::class,'restorePassword']);
    Route::post('reset', [UserController::class,'resetPassword']);
});

Route::group([
    'prefix' => 'company'
], function () {
    Route::post('create', [CompanyController::class, 'CreateCompany']);
    Route::put('put', [CompanyController::class, 'UpdateCompany']);



    Route::get('{id_company}/projects', [ProjectController::class,'getAllProject']);
    Route::post('{id_company}/projects/create', [ProjectController::class,'createProject']);
    Route::get('{id_company}/projects/{id_project}', [ProjectController::class,'getByIdProject']);
    Route::put('{id_company}/projects/{id_project}', [ProjectController::class,'updateProject']);

    Route::get('{id_company}/projects/{id_project}/roles', [RoleController::class,'GetRole']);
    Route::post('{id_company}/projects/{id_project}/roles/create', [RoleController::class ,'CreateRole']);
    Route::get('{id_company}/projects/{id_project}/roles/{id_role}', [RoleController::class,'GetRoleById']);
    Route::delete('{id_company}/projects/{id_project}/roles/{id_role}', [RoleController::class,'DeleteRole']);
    Route::put('{id_company}/projects/{id_project}/roles/{id_role}', [RoleController::class,'UpdateRole']);



    Route::get('{id_company}/projects/{id_project}/user/roles', [RoleController::class,'GetRoleFromUser']);
    Route::get('{id_company}/projects/{id_project}/roles/{id_role}/users', [RoleController::class,'getAllUserFromRole']);
    Route::post('{id_company}/projects/{id_project}/roles/{id_role}/users/set', [RoleController::class,'SetUserRole']);
    Route::post('{id_company}/projects/{id_project}/roles/{id_role}/users/remove', [RoleController::class,'RemoveUserRole']);


    Route::get('{id_company}/projects/{id_project}/columns', [ColumnController::class,'getAll']);
    Route::get('{id_company}/projects/{id_project}/columns/{id_column}', [ColumnController::class,'getById']);
    Route::post('{id_company}/projects/{id_project}/columns/create', [ColumnController::class,'create']);
    Route::put('{id_company}/projects/{id_project}/columns/{id_column}', [ColumnController::class,'update']);
    Route::delete('{id_company}/projects/{id_project}/columns/{id_column}', [ColumnController::class,'delete']);

    Route::get('{id_company}/projects/{id_project}/columns/{id_column}/tasks',[TaskController::class,'getAll']);
    Route::get('{id_company}/projects/{id_project}/columns/{id_column}/tasks/{id_task}',[TaskController::class,'getById']);
    Route::post('{id_company}/projects/{id_project}/columns/{id_column}/tasks',[TaskController::class,'create']);
    Route::put('{id_company}/projects/{id_project}/columns/{id_column}/tasks/{id_task}',[TaskController::class,'update']);
});
Route::group([
    'prefix' => 'user'
], function () {
    Route::get('all', [UserController::class,'getAll']);
    Route::get('{id}', [UserController::class,'getById']);
    Route::put('{id}/put', [UserController::class,'updateUser']);

    Route::post('/remove',[UserController::class,'removeUsers']);
});
