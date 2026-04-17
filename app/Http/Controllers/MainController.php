<?php

namespace App\Http\Controllers;

use App\Models\Note;
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
        // create new notes
        return view('new_note');
    }

    public function newNoteSubmit(Request $request) {
        // form validation
        $request->validate([
            // rules
            'text_title' => 'required|min:3|max:200',
            'text_note' => 'required|min:3|max:3000'
        ],[
            // error messages
            'text_title.required' => 'O título é obrigatório',
            'text_title.min' => 'O título precisa ter no mínimo :min caracteres.',
            'text_title.max' => 'O título precisa ter no máximo :max caracteres.',
            'text_note.required' => 'A descrição da nota é obrigatório.',
            'text_note.min' => 'A descrição precisa ter no mínimo :min caracteres.',
            'text_note.max' => 'A descrição precisa ter no máximo :max caracteres.',
        ]);

        // get user id
        $user_id = session('user.id');

        // get inputs
        $title = $request->input('text_title');
        $text = $request->input('text_note');

        // create a new note
        $note = new Note();
        $note->user_id = $user_id;
        $note->title = $title;
        $note->text = $text;
        $note->save();

        // redirect to home
        return redirect()->route('home');
    }

    // edit note
    public function editNote($id) {
        $id = Operations::decryptId($id);

        // load note
        $note = Note::find($id);

        // show edit notes view
        return view('edit_note', ['note' => $note]);
    }

    public function editNoteSubmit(Request $request) {
        // validate request
        $request->validate([
            // rules
            'text_title' => 'required|min:3|max:200',
            'text_note' => 'required|min:3|max:3000',
        ], [
            // erros messages
            'text_title.required' => 'O título é obrigatório',
            'text_title.min' => 'O título precisa ter no mínimo :min caracteres.',
            'text_title.max' => 'O título precisa ter no máximo :max caracteres.',
            'text_note.required' => 'A descrição é obrigatória.',
            'text_note.min' => 'A descrição precisa ter no mínimo :min caracteres.',
            'text_note.max' => 'A descrição precisa ter no máximo :max caracteres.',
        ]);

        // check if note_id exists
        if($request->note_id == null) {
            redirect()->route('home');
        }

        // descrypt note_id
        $note_id = Operations::decryptId($request->note_id);

        // load note
        $upNote = Note::find($note_id);

        // update note
        $upNote->title = $request->input('text_title');
        $upNote->text = $request->input('text_note');
        // $upNote->updated_at = date('Y-m-d H:i:s');
        $upNote->save();

        // redirect to home
        return redirect()->route('home');
    }

    // delete note
    public function deleteNote($id) {
        $id = Operations::decryptId($id);
        echo $id;
    }
}
