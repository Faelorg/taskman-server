<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\ProjectStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Project extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'id_project';
    public $timestamps=false;
    protected $fillable = [
        'id_project',
        'name',
        'description',
        'id_company',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(ProjectStatus::class, 'id_status', 'id');
    }
}
