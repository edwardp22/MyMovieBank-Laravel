@extends('layouts.layout')
@section('title', 'Showing Now')

<?php $activeLink = "about"; ?>

@section('content')
<h2>About Us</h2>

<div class="col-12 col-md-4">
  <img src="{{ asset('images/about1.jpg') }}" alt="Spiral film strip" style="width: 300px;" />
</div>

<div class="col-12 col-md-8">
  <p>My Movie Bank is a tool for storing our favorite movies.</p>

  <p>
    This page was created by a necessity that many people have to manage
    their movie list. Feel free to use this tool for your convenience.
  </p>

  <p>
    This webpage is managing all information in one MySQL database, and getting the information of the movies from IMDB.
  </p>
</div>
@endsection