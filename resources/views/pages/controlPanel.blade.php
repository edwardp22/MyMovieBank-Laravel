@extends('layouts.layout')
@section('title', $viewData['title'])

<?php $activeLink = $viewData['activeLink']; ?>

@section('content')
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Title</th>
                <th>Comment</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($viewData['list'] as $comment)    
            <tr>
                <td>{{ $comment['username'] }}</td>
                <td>{{ $comment['title'] }}</td>
                <td>{{ $comment['content'] }}</td>
                @if ($comment['isRejected'] == 0) 
                <td><a class="btn btn-danger" href="{{ route('admin.toggle', $comment['commentId']) }}">Reject this Comment</a></td>
                @else
                <td><a class="btn btn-primary" href="{{ route('admin.toggle', $comment['commentId']) }}">Return this Comment</a></td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection