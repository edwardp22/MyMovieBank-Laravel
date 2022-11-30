@extends('layouts.layout')
@section('title', $movies['title'])

<?php $activeLink = $movies['activeLink']; ?>

@section('content')
    @if (isset($movies['error']))
    <h1>{{ $movies['error'] }}</h1>
    @endif

    @foreach ($movies['list'] as $movie)
    <div class="col-12 col-md-4">
        <div 
            class="<?php 
                if (isset($movie["isFavorite"]) && $movie["isFavorite"]) echo 'card favorite';
                else echo 'card';
            ?>"
            id="<?php echo 'card'.$movie['id']; ?>" 
            
        >
            @auth
            <a
                class="starLink" 
                href="{{ route('favorite.toggle', $movie['id']) }}"
            >
                <i 
                    class="<?php
                        if (isset($movie["isFavorite"]) && $movie['isFavorite']) echo 'fa-solid fa-star';
                        else echo 'fa-regular fa-star';
                    ?>" 
                    id="{{ 'star'.$movie['id'] }}"
                ></i>
            </a>
            
            @if ($movies['activeLink'] == 'coming')
            <a
                class="starLink" 
                href="{{ route('wishlist.toggle', $movie['id']) }}"
            >
                <i 
                    class="<?php
                        if (isset($movie["isBookmarked"]) && $movie['isBookmarked']) echo 'fa-solid fa-bookmark';
                        else echo 'fa-regular fa-bookmark';
                    ?>" 
                    id="{{ 'bookmark'.$movie['id'] }}"
                ></i>
            </a>
            @endif
            @endauth

            <img 
                src="{{ $movie['image'] }}" 
                class="card-img-top" 
                alt="" loading="lazy"
                onclick="<?php echo "location.href='".route('movie.show', $movie['id'])."'" ?>"
            />

            <div 
                class="card-body"
                onclick="<?php 
                    if (isset($movie["isFavorite"]) && $movie['isFavorite']) $movie['isFavorite'] = true;
                    else $movie['isFavorite'] = false; 
                    
                    route('movie.show', $movie['id']); 
                ?>"
            >
                <h5 class="card-title">
                    {{ $movie['fullTitle'] }}
                    <br /> 
                    <?php if (isset($movie['contentRating'])) { ?>
                        <span class="badge rounded-pill bg-info">{{ $movie['contentRating'] }}</span>
                    <?php } ?>
                </h5>

                <?php if (isset($movie['plot'])) { ?>
                <p class="card-text">{{ $movie['plot'] }}</p>
                <?php } ?>
            </div>                  
        </div>
    </div>
    @endforeach
@endsection