@extends('layouts.layout')
@section('title', 'Editing comment')

<?php $activeLink = ""; ?>

@section('content')
    @auth
    <h5>Your profile</h5>
    <form method="POST" action="{{ route('user.update') }}">
        @csrf

        <div>
            <label for="name">Name</label> 
        </div>
        <div>
            <input id="name" name="name" required value="{{ $viewData['name'] }}">
        </div>

        <div>
            <label for="email">Email</label> 
        </div>
        <div>
            <input id="email" name="email" required value="{{ $viewData['email'] }}">
        </div>

        <input type="submit" class="btn btn-primary" value="Update Profile">
        
        @if (session()->get('message'))
        <div class="alert alert-success" role="alert">
            <strong>Success: </strong>{{ session()->get('message') }}
        </div>
        @endif
    </form>
    @endauth
@endsection