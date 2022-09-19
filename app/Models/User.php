<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const E_USER_NOT_FOUND = -1;
    const E_USER_INVALID = -2;
    const E_PASSWORD_MISMATCH = -3;
    const E_PASSWORD_SHORT = -4;

    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function login($email, $password) {

        $user = User::where('email', $email)->first();

        if (!$user) {
            return User::E_USER_NOT_FOUND;
        }

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            session('id_user', $user->id_user);
            session('user_name', $user->name);
            return true;
        } else {
            return User::E_USER_INVALID;
        }

    }

    public static function logout() {

        Relatorio::saveLogout();
        Auth::logout();
        return;

    }

    public static function getUsers() {

        return User::selectRaw("*, users.name AS user, roles.name AS role, DATE_FORMAT(users.created_at, '%d/%m/%Y %H:%i:%s') AS created, DATE_FORMAT(users.updated_at, '%d/%m/%Y %H:%i:%s') AS updated")
                        ->join('roles', 'roles.id_role', '=', 'users.id_role')
                        ->get();

    }

    public static function saveUser($data) {

        $name               = $data['name'];
        $id_role            = (int) $data['id_role'];
        $email              = $data['email'];
        $password           = $data['password'];
        $password_confirm   = $data['password_confirm'];

        if ($password != $password_confirm) {
            return User::E_PASSWORD_MISMATCH;
        }

        if (strlen($password) < 6) {
            return User::E_PASSWORD_SHORT;
        }

        if (!isset($data['id_user'])) {

            $user = new User();

            $user->name = $name;
            $user->id_role = $id_role;
            $user->email = $email;
            $user->password = Hash::make($password);
            
            $user->created_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');
            $user->updated_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');

            $user->save();

            return $user->id_user;

        } else {

            $user = User::find($data['id_user']);

            if ($user) {

                $user->name = $name;
                $user->id_role = $id_role;
                $user->email = $email;
                $user->password = Hash::make($password);
                
                $user->updated_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');

                $user->save();

                return true;

            } else {
                return User::E_USER_NOT_FOUND;
            }

        }

    }

    public static function deleteUser($id) {

        User::where('id_user', $id)->delete();
        return;

    }

    public static function getLastId() {

        DB::getPdo()->lastInsertId();

    }

    public static function getGithubUser($id) {

        $user = User::where('id_github', $id)->first();

        if (!$user)
            return false;

        return $user;

    }

    public static function saveGithubUser($id, $name, $email) {

        $user = new User();

        $user->name = $name;
        $user->id_role = 1;
        $user->email = $email;
        $user->id_github = $id;
            
        $user->created_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');
        $user->updated_at = Carbon::now()->setTimezone('UTC')->format('Y-m-d H:i:s');

        $user->save();

        return $user->id_user;

    }

}
