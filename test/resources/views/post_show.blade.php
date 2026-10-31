@extends('Layout.app')

@section('content')
    <h1>Post Show</h1>
    <ul>
        <li> id: {{ $post->id }}</li>
        <li> title: {{ $post->title }}</li>
        <li> content: {{ $post->content }}</li>
        <li> created_at: {{ $post->created_at }}</li>
        <li> updated_at: {{ $post->updated_at }}</li>
    </ul>

    
@endsection