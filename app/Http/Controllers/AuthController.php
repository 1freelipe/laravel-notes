<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login() {
        return view('login');
    }

    public function loginSubmit(Request $request) {
        // Form validation
        $request->validate([
            // rules
            'text_username' => 'required|email',
            'text_password' => 'required|min:6|max:16'
        ], [
            // error messages
            'text_username.required' => 'O username é obrigatório.',
            'text_username.email' => 'Username deve ser um e-mail válido.',
            'text_password.required' => 'A senha é obrigatória.',
            'text_password.min' => 'A senha deve conter no mínimo :min caracteres.',
            'text_password.max' => 'A senha deve conter no máximo :max caracteres.'
        ]);

        // Get user input
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // check if users exists
        $user = User::where('username', $username)
                        ->where('deleted_at', NULL)
                        ->first();

        if(!$user) {
            return redirect()->back()->withInput()->with('loginError', 'Usuário ou senha incorretos.');
        }

        // check if password is correct
        if(!password_verify($password, $user->password)) {
            return redirect()->back()->withInput()->with('loginError', 'Usuário ou senha incorretos.');
        }

        // update last_login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        // login user
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

        echo 'Olá, ' . $username . ' seja bem vindo.';

    }

    public function logout() {
        // logout from the application
        session()->forget('user');
        return redirect()->to('/login');
    }
}
