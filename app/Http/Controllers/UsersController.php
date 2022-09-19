<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    public function __construct(Request $request) {
    }

    public function index(Request $request) {

        $users = User::getUsers();

        return view('users.index', compact('users'));

    }    

    public function add(Request $request) {

        if ($request->isMethod('post')) {
            $result = User::saveUser($request->all());
            if ($result > 0 || $result === true) {
                $users = User::getUsers();
                return view('users.index', compact('users'));
            } else {
                switch ($result) {
                    case -1:
                        $message = 'Usuário não encontrado.';
                        break;
                    case -2:
                        $message = 'Usuário ou senha inválida.';
                        break;
                    case -3:
                        $message = 'Senha e confirmação não conferem.';
                        break;
                    case -4:
                        $message = 'Senha deve possuir no mínimo 6 caracteres.';
                        break;
                }
                Session::flash('message', $message);
            }
        }

        $roles = Roles::get();

        return view('users.add', compact('roles'));

    }    

    public function change(Request $request) {

        if ($request->isMethod('post')) {
            $result = User::saveUser($request->all());
            if ($result > 0 || $result === true) {
                $users = User::getUsers();
                return view('users.index', compact('users'));
            } else {
                switch ($result) {
                    case -1:
                        $message = 'Usuário não encontrado.';
                        break;
                    case -2:
                        $message = 'Usuário ou senha inválida.';
                        break;
                    case -3:
                        $message = 'Senha e confirmação não conferem.';
                        break;
                    case -4:
                        $message = 'Senha deve possuir no mínimo 6 caracteres.';
                        break;
                }
                Session::flash('message', $message);

            }
        }

        $user = User::find($request->id);
        $roles = Roles::get();

        return view('users.change', compact('user', 'roles'));

    }    

    public function delete(Request $request) {

        if (isset($request->id)) {
            User::deleteUser($request->id);
            Session::flash('message', 'Registro excluído com sucesso.');
            return redirect()->route('users.index');
        }

    }    



}
