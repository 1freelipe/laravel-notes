<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\services\Operations;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MainController extends Controller
{
    public function index() {
        // load users notes
        $id = session('user.id');
        $notes = User::find($id)->notes()->get()->toArray();

        // show home view
        return view('home', ['notes' => $notes]);
    }

    public function newNote() {
        echo 'I am a create a new note';
    }

    // edit note
    public function editNote($id) {

        $id = Operations::decryptId($id);
        echo $id;
    }

    // delete note
    public function deleteNote($id) {
        $id = Operations::decryptId($id);
        echo $id;
    }
}
