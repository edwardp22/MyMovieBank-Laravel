<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;

class NotesController extends Controller {
    // Captures the new note of the user
    public function addNote(Request $request, string $id) {
        $user = auth()->user();
        $formData = $request->all();

        if (isset($user) && isset($formData['note'])) {
            $userId = $user->id;

            $note = Note::where(
                [
                    ['imDbId', '=', $id],
                    ['userId', '=', $userId]
                ]
            )->get()->toArray();

            if (isset($note) && sizeof($note) > 0) {
                Note::where(
                    [
                        ['imDbId', '=', $id],
                        ['userId', '=', $userId]
                    ]
                )->update([
                    "note" => $formData['note'],
                ]);
            }
            else {
                $newComment = new Note();
                $newComment->userId = $userId;
                $newComment->imDbId = $id;
                $newComment->note = $formData['note'];
                $newComment->save();
            }
        }

        return back()->with('message','Note Saved!');
    }
}
?>