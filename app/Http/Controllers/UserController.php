<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Company;
use App\Models\Invite;
use App\Models\ResetPassword;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login', 'registration', 'restorePassword', 'resetPassword']]);
    }

    public function login(){
        $email = request('email');
        $password = request('password');

        if (! $token = auth()->attempt(['email'=>$email, 'password'=>$password])) {

            if (! $token = auth()->attempt(['login'=>$email, 'password'=>$password])) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }

        return $this->respondWithToken($token);
    }

    public function registration(){
        $id_invite = request('id_invite');
        $invite = Invite::findOrFail($id_invite);
        $email = $invite->email;
        $password = request('password');
        $firstname = request('firstname');
        $lastname = request('lastname');
        $middlename = request('middlename');
        $id_company = $invite->id_company;
        $login = is_null(request('login'))?explode('@', $email)[0]:request('login');

        $user = new User();
        $user->email = $email;
        $user->lastname = $lastname;
        $user->middlename = $middlename;
        $user->firstname = $firstname;
        $user->password = Hash::make($password);
        $user->id_user = request('id_invite');
        $user->login = $login;
        $user->is_admin = false;
        $user->id_company=$id_company;
        $user->save();
        $invite->delete();

        if (Company::find(request('id_invite'))) {
            $user->setAdmin(request('id_invite'));
        }

        if (! $token = auth()->attempt(['email'=>$email, 'password'=>$password])) {
            if (! $token = auth()->attempt(['login'=>$login, 'password'=>$password])) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }


        return $this->respondWithToken($token);
    }

    public function inviteUser(){
        $user = auth()->user();
        $email = request('email');
        $id_invite = Str::uuid();
        $invite = new Invite();
        $id_company = $user->id_company;
        $invite->email = $email;
        $invite->id_company = $id_company;
        $invite->id_invite = $id_invite;
        $invite->save();

        $invite->sendInvite($id_company, $email, $id_invite);
    }

    public function getProfile(){
        return response()->json(auth()->user());
    }

    public function logout(){
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function getAll(){
        $user = auth()->user();

        return Company::find($user->id_company)->users;
    }

    public function getCompany(){
        $user = auth()->user();
        return Company::find($user->id_company);
    }

    public function restorePassword(){
        $email = request('email');
        $id_reset = Str::uuid();
        $user = User::where('email',$email)->get()->first();
        $reset = new ResetPassword();
        $id_company = $user->id_company;
        $reset->email = $email;
        $reset->id_company = $id_company;
        $reset->id_reset = $id_reset;
        $reset->save();

        $reset->resetPassword($email, $id_reset);
    }

    public function resetPassword(){
        $id_reset = request('id_reset');
        $reset = ResetPassword::findOrFail($id_reset);
        $user = User::where('email', $reset->email)->get()->first();
        $user->password = Hash::make(request('password'));
        $user->save();

        $reset->delete();
    }

    public function getById($id) {
        $user = auth()->user();

        return Company::find($user->id_company)->users->find($id);
    }

    public function updateUser($id){
       $auth = $user = auth()->user();
       if ($auth->is_admin) {
        $user = Company::find($user->id_company)->users->find($id);
        $email = $user->email;
        $password = request('password');
        $firstname = request('firstname');
        $lastname = request('lastname');
        $middlename = request('middlename');
        $login = is_null(request('login'))?explode('@', $email)[0]:request('login');

        $user->email = $email;
        $user->lastname = $lastname;
        $user->middlename = $middlename;
        $user->firstname = $firstname;
        $user->login = $login;

        $user->save();
        return;
       }
       return Response::json(['error' => 'Недостаточно прав'], 403);
    }

    public function removeUsers(){
        $ids = request('ids');

        foreach ($ids as $id) {
            $user = User::find($id);
            if (!$user->is_admin) {
                $user->delete();
            }
        }
    }


    protected function respondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
