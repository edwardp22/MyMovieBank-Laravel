<?php

namespace App\Http\Controllers;

use App\Models\Comment;

class AdminController extends Controller {
    // Show Wish page
    public function controlPanel() {
        $viewData = array();
        $viewData['activeLink'] = 'adminPanel';
        $viewData['title'] = 'Control Panel';
        $viewData['list'] = array();
        $user = auth()->user();

        if (isset($user) && $user->isAdmin == 1) {
            $comments = Comment::get()->toArray();

            if (sizeof($comments) == 0) {
                $viewData['error'] = 'Nothing in comments';
            }

            $viewData['list'] = $comments;
        }
        else {
            $viewData['error'] = 'You need to log in to see your control panel';
        }

        return view("pages.controlPanel")->with('viewData', $viewData);
    }

    // Changes the state of the comment
    public function toggleComment($id) {
        $user = auth()->user();

        if (isset($user) && $user->isAdmin == 1) {
            $comments = Comment::where(
                [
                    ['commentId', '=', $id],
                ]
            )->get()->toArray();

            if (isset($comments) && sizeof($comments) > 0) {
                if ($comments[0]['isRejected'] == 0){
                    $rejectedStatus = 1;
                }
                else {
                    $rejectedStatus = 0;
                }

                Comment::where(
                    [
                        ['commentId', '=', $id]
                    ]
                )->update([
                    "isRejected" => $rejectedStatus,
                ]);
            }
        }        

        return back();
    }
}
?>