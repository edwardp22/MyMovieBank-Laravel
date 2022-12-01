<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller {
    // Open the profile screen
    public function profile() {
        $user = auth()->user();

        if (isset($user)) {
            $viewData = array(
                'name' => $user->name,
                'email' => $user->email,
            );
        }

        return view('pages.profile')->with('viewData', $viewData);
    }

    // Edits profile
    public function profileUpdate(Request $request) {
        $user = auth()->user();
        $formData = $request->all();

        if (isset($user) && isset($formData['name']) && isset($formData['email'])) {
            $userId = $user->id;

            User::where(
                [
                    ['id', '=', $userId]
                ]
            )->update([
                "name" => $formData['name'],
                "email" => $formData['email'],
            ]);
        }

        return back()->with('message','Profile Updated');
    }
}
?>