<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\User;
use App\Models\Invite;

class Company extends Model
{
    use HasUuids;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $primaryKey = 'id_company';
    public $timestamps=false;
    protected $fillable = [
        'id_company',
        'name',
        'maincolor',
        'additionalcolor',
        'panelcolor',
        'additionalpanelcolor',
        'outlinecolor',
        'additionalfontcolor',
        'mainpage',
        'codetask',
        'smtpsender',
        'smtpprovider',
        'smtpserver',
        'smtpport',
        'smtplogin',
        'smtppassword',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_company','id_company');
    }

    public function invites(): HasMany
    {
        return $this->hasMany(Invite::class, 'id_company','id_company');
    }
}
