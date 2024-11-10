<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Company;
use App\Models\User;
use App\Models\RoleUser;
use App\Models\Role;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'id_user';
    public $timestamps=false;
    protected $fillable = [
        'id_user',
        'login',
        'email',
        'password',
        'firstname',
        'lastname',
        'middlename',
        'is_admin',
        'id_company'
    ];

    protected $hidden = [
        'password',
    ];
    protected $casts = [
        'password' => 'hashed',
    ];

    public function setAdmin($id_user) {
        $user = User::find($id_user);
        $user->is_admin = true;
        $user->save();
    }

    public function getRoleProject($id_project){
        $roleuser = RoleUser::where(['id_project'=>$id_project,'id_user'=>$this->id_user])->first();
        if ($roleuser != null) {
            return Role::find($roleuser->id_role);
        }
        return false;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return ['id_user'=>$this->id_user, 'isAdmin'=>$this->is_admin];
    }
}
