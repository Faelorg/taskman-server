<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Role extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'id_role';
    protected $fillable = [
        'id_role',
        'name',
        'description',
        'close_project',
        'update_project',
        'create_column',
        'update_column',
        'delete_column',
        'create_task',
        'update_task',
        'delete_task',
        'id_project'
    ];
    public $timestamps=false;

}
