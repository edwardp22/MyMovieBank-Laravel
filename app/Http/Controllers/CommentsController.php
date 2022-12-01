<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller {
    // Captures the new comment of the user
    public function addComment(Request $request, string $id) {
        $user = auth()->user();
        $formData = $request->all();

        if (isset($user) && isset($formData['rate']) && isset($formData['title']) && isset($formData['content'])) {
            $userId = $user->id;
            $username = $user->name;

            $newComment = new Comment();
            $newComment->userId = $userId;
            $newComment->imDbId = $id;
            $newComment->username = $username;
            $newComment->date = Carbon::now();
            $newComment->rate = $formData['rate'];
            $newComment->title = $formData['title'];
            $newComment->content = $formData['content'];
            $newComment->save();
        }

        return back();
    }

    // Edits one comment
    public function editComment(Request $request, string $id) {
        $user = auth()->user();
        $formData = $request->all();

        if (isset($user) && isset($formData['rate']) && isset($formData['title']) && isset($formData['content'])) {
            $userId = $user->id;

            Comment::where(
                [
                    ['commentId', '=', $id],
                    ['userId', '=', $userId]
                ]
            )->update([
                "rate" => $formData['rate'],
                "title" => $formData['title'],
                "content" => $formData['content'],
            ]);
        }

        return back()->with('message','Comment Updated');
    }

    // Deletes one comment
    public function deleteComment(string $id) {
        $user = auth()->user();

        if (isset($user)) {
            $userId = $user->id;

            Comment::where(
                [
                    ['commentId', '=', $id],
                    ['userId', '=', $userId]
                ]
            )->delete();
        }

        return back();
    }

    // Open the editor
    public function editor(string $id) {
        $user = auth()->user();

        if (isset($user)) {
            $userId = $user->id;

            $comments = Comment::where(
                [
                    ['commentId', '=', $id],
                    ['userId', '=', $userId]
                ]
            )->get()->toArray();

            $viewData = $comments[0];
        }

        return view('pages.editor')->with('viewData', $viewData);
    }
}
?>