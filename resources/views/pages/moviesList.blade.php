@extends('layouts.layout')
@section('title', 'Showing Now')

<?php $activeLink = $movies['activeLink']; ?>

@section('content')
    @foreach ($movies['list'] as $movie)
    <div class="col-12 col-md-4">
        <div 
            class="<?php 
                if ($movie["isFavorite"]) echo 'card favorite';
                else echo 'card';
            ?>"
            id="<?php echo 'card'.$movie['id']; ?>" 
            
        >
            <a 
                class="starLink" 
                href="{{ route('favorite.toggle', $movie['id']) }}"
            >
                <i 
                    class="<?php
                        if ($movie['isFavorite']) echo 'fa-solid fa-star';
                        else echo 'fa-regular fa-star';
                    ?>" 
                    id="{{ 'star'.$movie['id'] }}"
                ></i>
            </a>    

            <img 
                src="{{ $movie['image'] }}" 
                class="card-img-top" 
                alt="" loading="lazy"
                onclick="<?php echo "location.href='".route('movie.show', $movie['id'])."'" ?>"
            />

            <div 
                class="card-body"
                onclick="<?php 
                    if ($movie['isFavorite']) $movie['isFavorite'] = true;
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