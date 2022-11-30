@extends('layouts.layout')
@section('title', 'Editing comment')

<?php $activeLink = ""; ?>

@section('content')
    @auth
    <h5>Edit your comment</h5>
    <form method="POST" action="{{ route('comment.edit', $viewData['commentId']) }}">
        @csrf

        <select class="form-select" id="rate" name="rate" required>
            <option value="1" <?php if ($viewData['rate'] == 1) echo 'selected'; ?>>&#xf005;</option>
            <option value="2" <?php if ($viewData['rate'] == 2) echo 'selected'; ?>>&#xf005;&#xf005;</option>
            <option value="3" <?php if ($viewData['rate'] == 3) echo 'selected'; ?>>&#xf005;&#xf005;&#xf005;</option>
            <option value="4" <?php if ($viewData['rate'] == 4) echo 'selected'; ?>>&#xf005;&#xf005;&#xf005;&#xf005;</option>
            <option value="5" <?php if ($viewData['rate'] == 5) echo 'selected'; ?>>&#xf005;&#xf005;&#xf005;&#xf005;&#xf005;</option>
        </select>

        <div>
            <label for="title">Title</label> 
        </div>
        <div>
            <input id="title" name="title" required value="{{ $viewData['title'] }}">
        </div>

        <div>
            <label for="content">Comment</label> 
        </div>
        <div>
            <textarea id="content" name="content" rows="4" cols="50" required>{{ $viewData['content'] }}</textarea>
        </div>

        <input type="submit" class="btn btn-primary" value="Edit Comment">
        <a class="btn btn-secondary" href="{{ route('movie.show', $viewData['imDbId']) }}">Cancel</a>
        
        @if (session()->get('message'))
        <div class="alert alert-success" role="alert">
            <strong>Success: </strong>{{ session()->get('message') }}
        </div>
        @endif
    </form>
    @endauth
@endsection