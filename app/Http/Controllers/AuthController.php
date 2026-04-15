<?php

namespace App\Http\Controllers;

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

        // test database connection
        try {
            DB::connection()->getPdo();
            echo 'Connection successfull';
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function logout() {
        echo 'logout';
    }
}
