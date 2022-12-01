<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use App\Models\Wish;

class WishesController extends Controller {
    // private static string $apiKey = 'k_3ia6todj';
    private static string $apiKey = 'k_145rs2xn';

    // Show Wish page
    public function show() {
        $viewData = array();
        $viewData['activeLink'] = 'wishes';
        $viewData['title'] = 'My Wish List';
        $viewData['list'] = array();
        $user = auth()->user();

        if (isset($user)) {
            $userId = $user->id;

            $wishes = Wish::where(
                [
                    ['userId', '=', $userId]
                ]
            )->get()->toArray();

            if (sizeof($wishes) == 0) {
                $viewData['error'] = 'Nothing in wishes';
            }

            try {
                for ($i=0; $i < sizeof($wishes); $i++) { 
                    $movie = Http::get('https://imdb-api.com/en/API/Title/'.self::$apiKey.'/'.$wishes[$i]['imDbId'])->json();
                    $movie['isBookmarked'] = true; 

                    if (isset($movie['errorMessage']) && $movie['errorMessage'] != '') {
                        $viewData['error'] = $movie['errorMessage'];
                        break;
                    }

                    $viewData['list'][] = $movie;
                }
            } catch(ConnectionException $e)
            {
                $viewData['error'] = 'You are not connected to Internet';
            }
        }
        else {
            $viewData['error'] = 'You need to log in to see your wish list';
        }

        return view("pages.moviesList")->with('movies', $viewData);
    }

    // Changes the state of wish list for the movie
    public function toggleWishList($id) {
        $user = auth()->user();

        if (isset($user)) {
            $userId = $user->id;

            $wish = Wish::where(
                [
                    ['imDbId', '=', $id],
                    ['userId', '=', $userId]
                ]
            )->get()->toArray();
    
            if (sizeof($wish) > 0) {
                Wish::where(
                    [
                        ['imDbId', '=', $id],
                        ['userId', '=', $userId]
                    ]
                )->delete();
            }
            else {
                $newWish = new Wish();
                $newWish->userId = $userId;
                $newWish->imDbId = $id;
                $newWish->save();
            }
        }        

        return back();
    }
}
?>