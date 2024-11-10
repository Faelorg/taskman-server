<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Task extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'id_task';
    public $timestamps=false;
    protected $fillable = [
        'id_task',
        'name',
        'description',
        'code',
        'status',
        'id_column',
        'id_user',
    ];
}
