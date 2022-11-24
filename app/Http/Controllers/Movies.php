<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Favorite;
use App\Models\Comment;

class Movies extends Controller {
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

    // Show information of the desired movie
    public function showMovie($id) {
        $viewData = Http::get('https://imdb-api.com/en/API/Title/k_3ia6todj/'.$id)->json();
        
        $user = auth()->user();

        if (isset($user)) {
            $userId = $user->id;
        
            $response = Http::get('https://imdb-api.com/en/API/Reviews/k_3ia6todj/'.$id)->json();
            $comments = $response["items"];
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
                $viewData['comments'][] = $comments[$i]; 
            }
        }

        return view("pages.movie")->with('movie', $viewData);
    }

    // Common utility function for all pages
    private function getViewData(string $activeLink, string $endPoint, int $numRecords = 0): array {
        $viewData = array();
        $viewData['activeLink'] = $activeLink;
        $response = Http::get('https://imdb-api.com/en/API/'.$endPoint.'/k_3ia6todj')->json();
        
        if ($numRecords != 0) {
            $viewData['list'] = array_slice($response['items'], 0, $numRecords);
        }
        else {
            $viewData['list'] = $response['items'];
        }

        $favorites = Favorite::get()->toArray();

        for ($i=0; $i < sizeof($viewData['list']); $i++) { 
            $setFavorite = false;

            foreach ($favorites as $favorite) {
                if ($favorite['imDbId'] == $viewData['list'][$i]['id']) {
                    $setFavorite = true;
                    break;
                }
            }

            $viewData['list'][$i]['isFavorite'] = $setFavorite; 
        }

        return $viewData;
    }
}
?>