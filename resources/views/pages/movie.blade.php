@extends('layouts.layout')
@section('title', 'Showing Now')

<?php $activeLink = ""; ?>

@section('content')
    @if (isset($movies['error']))
        <h1>{{ $movies['error'] }}</h1>
    @else
        <div class="row">
            <div class="col-12 col-md-4">
                <img 
                    class="img-fluid"
                    src="{{ $movie['image'] }}"  
                    alt="" loading="lazy"
                />
            </div>

            <div class="col-12 col-md-8">
                <h2>{{ $movie['fullTitle'] }}</h2>
                <h6>
                    <?php if (isset($movie['releaseDate'])) echo 'Realease Date: '.$movie['releaseDate']; ?>
                    <?php if (isset($movie['contentRating'])) { ?>
                    <span class="badge rounded-pill bg-info">{{ $movie['contentRating'] }}</span>
                    <?php } ?>
                </h6>

                <hr>

                <p><b>Stars:</b> <?php if (isset($movie['stars'])) echo $movie['stars']; else echo 'N/A'; ?></p>
                <p><b>Summary:</b> <?php if (isset($movie['plot'])) echo $movie['plot']; else echo 'N/A'; ?></p>
                <p>
                    <b>Director(s):</b> <?php if (isset($movie['directors'])) echo $movie['directors']; else echo 'N/A'; ?><br>
                    <b>Writer(s):</b> <?php if (isset($movie['writers'])) echo $movie['writers']; else echo 'N/A'; ?><br>
                    <b>Companies(s):</b> <?php if (isset($movie['companies'])) echo $movie['companies']; else echo 'N/A'; ?><br>
                    <b>Genre(s):</b> <?php if (isset($movie['genres'])) echo $movie['genres']; else echo 'N/A'; ?><br>
                    <b>Language(s):</b> <?php if (isset($movie['languages'])) echo $movie['languages']; else echo 'N/A'; ?><br>
                    <b>Award(s):</b> <?php if (isset($movie['awards'])) echo $movie['awards']; else echo 'N/A'; ?><br>
                    <b>Runtime(s):</b> <?php if (isset($movie['runtimeStr'])) echo $movie['runtimeStr']; else echo 'N/A'; ?><br>
                </p>

                <?php if (isset($movie['trailer'])) { ?>
                    <video width="320" height="240" controls>
                        <source src="{{ $movie['trailer'] }}">
                        Your browser does not support the video tag.
                    </video>
                <?php } ?>
            </div>

            @auth
            @if (isset($movie['comments']))
            <div class="col-12">
                <h1>Comments</h1>
                @foreach ($movie['comments'] as $comment)            
                <div class="comment mt-4 text-justify float-left">
                    <h4>{{ $comment['username'] }}</h4>

                    <?php if (isset($comment['title'])) { ?>
                    <h5>{{ $comment['title'] }}</h5>
                    <?php } ?>

                    <span>- {{ $comment['date'] }}</span>
                    <br>
                    <p>{{ comment['content'] }}</p>
                </div>
                @endforeach
            </div>
            @endif
            @endauth
        </div>
    @endif
@endsection