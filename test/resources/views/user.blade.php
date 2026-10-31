@extends('Layout.app')

@section('title', 'User')

@section('content')
    <h1> User </h1>
    <ul>
        @foreach ($users as $user)
            <li> id: {{ $user->id }}</li>
            <li> name: {{ $user->name }}</li>
            <li> email: {{ $user->email }}</li>
            <li> posts: {{ $user->posts->count() }}</li>
            @foreach ($user->posts as $post)
                <li>title : {{ $post->title }} </li>
            @endforeach
            @foreach ($user->roles as $role)
                <li>role name: {{ $role->name }} </li>
            @endforeach
        @endforeach
    </ul>
@endsection