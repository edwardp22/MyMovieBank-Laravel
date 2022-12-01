<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use App\Models\Favorite;

class FavoritesController extends Controller {
    private static string $apiKey = 'k_3ia6todj';
    // private static string $apiKey = 'k_145rs2xn';

    // Show Favorite page
    public function show() {
        $viewData = array();
        $viewData['activeLink'] = 'favorites';
        $viewData['title'] = 'My Favorites';
        $viewData['list'] = array();
        $user = auth()->user();

        if (isset($user)) {
            $userId = $user->id;

            $favorites = Favorite::where(
                [
                    ['userId', '=', $userId]
                ]
            )->get()->toArray();

            if (sizeof($favorites) == 0) {
                $viewData['error'] = 'Nothing in favorites';
            }

            try {
                for ($i=0; $i < sizeof($favorites); $i++) { 
                    $movie = Http::get('https://imdb-api.com/en/API/Title/'.self::$apiKey.'/'.$favorites[$i]['imDbId'])->json();
                    $movie['isFavorite'] = true; 

                    if (isset($movie['errorMessage']) && $movie['errorMessage'] != '') {
                        $viewData['error'] = $movie['errorMessage'];
                        break;
                    }

                    $movie['note'] = $favorites[$i]['note'];
                    $viewData['list'][] = $movie;
                }
            } catch(ConnectionException $e)
            {
                $viewData['error'] = 'You are not connected to Internet';
            }
        }
        else {
            $viewData['error'] = 'You need to log in to see favorites';
        }

        return view("pages.moviesList")->with('movies', $viewData);
    }

    // Changes the state of favorite for the movie
    public function toggleFavorite($id) {
        $user = auth()->user();

        if (isset($user)) {
            $userId = $user->id;

            $favorite = Favorite::where(
                [
                    ['imDbId', '=', $id],
                    ['userId', '=', $userId]
                ]
            )->get()->toArray();
    
            if (sizeof($favorite) > 0) {
                Favorite::where(
                    [
                        ['imDbId', '=', $id],
                        ['userId', '=', $userId]
                    ]
                )->delete();
            }
            else {
                $newFavorite = new Favorite();
                $newFavorite->userId = $userId;
                $newFavorite->imDbId = $id;
                $newFavorite->save();
            }
        }        

        return back();
    }// Captures the new note of the user
    public function editFavorite(Request $request, string $id) {
        $user = auth()->user();
        $formData = $request->all();

        if (isset($user) && isset($formData['note'])) {
            $userId = $user->id;

            Favorite::where(
                [
                    ['imDbId', '=', $id],
                    ['userId', '=', $userId]
                ]
            )->update([
                "note" => $formData['note'],
            ]);
        }

        return back()->with('message','Note Saved!');
    }
}
?>