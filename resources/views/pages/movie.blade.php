@extends('layouts.layout')
@section('title', 'Movie')

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

                <form method="POST" action="{{ route('note.add', $movie['id']) }}">
                @csrf
                    <div>
                        <label for="note">Personal Notes</label> 
                    </div>
                    <div>
                        <textarea id="note" name="note" rows="4" cols="50" required>{{ $movie['note'] }}</textarea>
                    </div>
                    <input type="submit" value="Save Note">
                    @if (session()->get('message'))
                    <div class="alert alert-success" role="alert">
                        <strong>Success: </strong>{{ session()->get('message') }}
                    </div>
                    @endif
                </form>
            </div>

            @auth
            <h5>Please leave your comment</h5>
            <form method="POST" action="{{ route('comment.add', $movie['id']) }}">
                @csrf

                <select class="form-select" id="rate" name="rate" required>
                    <option value="1">&#xf005;</option>
                    <option value="2">&#xf005;&#xf005;</option>
                    <option value="3">&#xf005;&#xf005;&#xf005;</option>
                    <option value="4">&#xf005;&#xf005;&#xf005;&#xf005;</option>
                    <option value="5" selected>&#xf005;&#xf005;&#xf005;&#xf005;&#xf005;</option>
                </select>

                <div>
                    <label for="title">Title</label> 
                </div>
                <div>
                    <input id="title" name="title" required>
                </div>

                <div>
                    <label for="content">Comment</label> 
                </div>
                <div>
                    <textarea id="content" name="content" rows="4" cols="50" required></textarea>
                </div>

                <input type="submit" value="Send Comment">
            </form>

            @if (isset($movie['comments']))
            <div class="col-12">
                <h1>Comments</h1>
                @foreach ($movie['comments'] as $comment)       
                @if ($comment['isRejected'] == 0)     
                <div class="comment mt-4 text-justify float-left commentBlock">
                    <div><?php for ($i=0; $i < $comment['rate']; $i++) { 
                        echo '<i class="fa-solid fa-star"></i>';
                    } ?></div>
                    <h4>{{ $comment['username'] }}</h4>

                    <?php if (isset($comment['title'])) { ?>
                    <h5>{{ $comment['title'] }}</h5>
                    <?php } ?>

                    <span>- {{ $comment['date'] }}</span>
                    <br>
                    <p>{{ $comment['content'] }}</p>

                    @if ($comment['isInternal'])
                    <div>
                        <a class="btn btn-primary" href="{{ route('comment.editor', $comment['commentId']) }}">Edit my comment</a>
                        <a class="btn btn-danger" href="{{ route('comment.delete', $comment['commentId']) }}">Delete my comment</a>
                    </div>
                    @endif
                </div>
                @endif
                @endforeach
            </div>
            @endif
            @endauth
        </div>
    @endif
@endsection