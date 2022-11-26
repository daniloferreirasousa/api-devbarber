<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['create', 'login', 'unauthorized']]);
    }

    public function create(Request $request) {
        $array = ['error' => ''];

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(!$validator->fails()) {

            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');
     
            $hasEmail = User::where('email', $email)->count();

            if($hasEmail === 0) {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $user = new User();
                $user->name = $name;
                $user->email = $email;
                $user->password = $hash;
                $user->save();

                $token = auth()->attempt([
                    'email' => $email,
                    'password' => $password
                ]);

                if(!$token) {
                    $array['error'] = 'Occorreu um erro';
                    return $array;
                }

                $info = auth()->user();
                $info['avatar'] = url('media/avatars/'.$info['avatar']);
                $array['data'] = $info;
                $array['token'] = $token;

            } else {
                $array['error'] = 'E-mail já cadastrado';
                return $array;
            }

        } else {
            $array['error'] = 'Dados incorretos';
            return $array;
        }

        return $array;
    }


    public function login(Request $request) {
        $array = ['error' => ''];

        $email = $request->input('email');
        $password = $request->input('password');

        $token = auth()->attempt([
            'email' => $email,
            'password' => $password
        ]);

        if(!$token) {
            $array['error'] = 'E-mail e/ou senha errado';
            return $array;
        }

        $info = auth()->user();
        $info['avatar'] = url('media/avatars/'.$info['avatar']);
        $array['data'] = $info;
        $array['token'] = $token;

        return $array;
    }

    public function logout() {
        auth()->logout();
        return ['error' => ''];
    }


    public function refresh() {
        $array = ['error'=>''];

        $token = auth()->refresh();
        
        $info = auth()->user();
        $info['avatar'] = url('media/avatars/'.$info['avatar']);
        $array['data'] = $info;
        $array['token'] = $token;

        return $array;
    }


    public function unauthorized() {
        return response()->json([
            'error' => 'Não autorizado'
        ], 401);
    }
}
