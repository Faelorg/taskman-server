<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Column extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'id_column';
    protected $fillable = [
        'id_column',
        'name',
        'color',
        'id_project'
    ];
    public $timestamps=false;
}
