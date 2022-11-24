<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use App\Models\Favorite;
use App\Models\Wish;
use App\Models\Comment;

class Movies extends Controller {
    // private static string $apiKey = 'k_3ia6todj';
    private static string $apiKey = 'k_145rs2xn';

    // Show Showing now page
    public function showingNow() {
        $viewData = $this->getViewData('index', 'InTheaters');

        return view("pages.moviesList")->with('movies', $viewData);
    }

    // Show Coming page
    public function comingSoon() {
        $viewData = $this->getViewData('coming', 'ComingSoon');

        return view("pages.moviesList")->with('movies', $viewData);
    }

    // Show Top page
    public function top() {
        $viewData = $this->getViewData('top', 'Top250Movies', 10);

        return view("pages.moviesList")->with('movies', $viewData);
    }

    // Show Popular page
    public function popular() {
        $viewData = $this->getViewData('popular', 'MostPopularMovies');

        return view("pages.moviesList")->with('movies', $viewData);
    }

    // Show Favorite page
    public function favorites() {
        $viewData = array();
        $viewData['activeLink'] = 'favorites';
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

                    $viewData['list'][] = $movie;
                }
            } catch(ConnectionException $e)
            {
                $viewData['error'] = 'You are not connected to Internet';
            }
        }

        return view("pages.moviesList")->with('movies', $viewData);
    }

    // Show Wish page
    public function wishList() {
        $viewData = array();
        $viewData['activeLink'] = 'wishes';
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

        return view("pages.moviesList")->with('movies', $viewData);
    }

    // Show About page
    public function about() {
        return view("pages.about");
    }

    // Show Contact page
    public function contact() {
        return view("pages.contact");
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

    // Show information of the desired movie
    public function showMovie($id) {
        $viewData = array();
        $viewData['comments'] = array();

        try {
            $viewData = Http::get('https://imdb-api.com/en/API/Title/'.self::$apiKey.'/'.$id)->json();

            if (isset($viewData['errorMessage']) && $viewData['errorMessage'] != '') {
                $viewData['error'] = $viewData['errorMessage'];
            }
            else {            
                $user = auth()->user();

                if (isset($user)) {
                    $userId = $user->id;
                
                    $response = Http::get('https://imdb-api.com/en/API/Reviews/'.self::$apiKey.'/'.$id)->json();
                    $comments = array_slice($response["items"], 0, 9);
                    $DbComments = Comment::where(
                        [
                            ['imDbId', '=', $id],
                            ['userId', '=', $userId]
                        ]
                    )->get()->toArray();

                    for ($i=0; $i < sizeof($DbComments); $i++) {
                        $DbComments[$i]['isInternal'] = true; 
                        $viewData['comments'][] = $DbComments[$i];             
                    }

                    for ($i=0; $i < sizeof($comments); $i++) {
                        $comments[$i]['isInternal'] = false;
                        $viewData['comments'][] = $comments[$i]; 
                    }
                }
            }
        } catch(ConnectionException $e)
        {
            $viewData['error'] = 'You are not connected to Internet';
        }

        return view("pages.movie")->with('movie', $viewData);
    }

    // Common utility function for all pages
    private function getViewData(string $activeLink, string $endPoint, int $numRecords = 0): array {
        $viewData = array();
        $viewData['list'] = array();
        $viewData['activeLink'] = $activeLink;

        try {
            $response = Http::get('https://imdb-api.com/en/API/'.$endPoint.'/'.self::$apiKey)->json();

            if (isset($response['errorMessage']) && $response['errorMessage'] != '') {
                $viewData['error'] = $response['errorMessage'];
            }
            else {            
                if ($numRecords != 0) {
                    $viewData['list'] = array_slice($response['items'], 0, $numRecords);
                }
                else {
                    $viewData['list'] = $response['items'];
                }

                $user = auth()->user();

                if (isset($user)) {
                    $userId = $user->id;

                    $favorites = Favorite::where(
                        [
                            ['userId', '=', $userId]
                        ]
                    )->get()->toArray();

                    $wishes = Wish::where(
                        [
                            ['userId', '=', $userId]
                        ]
                    )->get()->toArray();

                    for ($i=0; $i < sizeof($viewData['list']); $i++) { 
                        $setFavorite = false;
                        $setBookmarked = false;

                        foreach ($favorites as $favorite) {
                            if ($favorite['imDbId'] == $viewData['list'][$i]['id']) {
                                $setFavorite = true;
                                break;
                            }
                        }

                        foreach ($wishes as $wish) {
                            if ($wish['imDbId'] == $viewData['list'][$i]['id']) {
                                $setBookmarked = true;
                                break;
                            }
                        }

                        $viewData['list'][$i]['isFavorite'] = $setFavorite; 
                        $viewData['list'][$i]['isBookmarked'] = $setBookmarked; 
                    }
                }
            }
        } catch(ConnectionException $e)
        {
            $viewData['error'] = 'You are not connected to Internet';
        }

        return $viewData;
    }
}
?>