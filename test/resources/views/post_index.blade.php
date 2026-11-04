@extends('Layout.app')

@section('title', 'index')

@section('content')
<div class="container py-5">
    <header class="text-center mb-5">
        <h1 class="display-4">Blog cá nhân</h1>
        <p class="lead text-muted">Nơi upload bài viết của bạn</p>
    </header>
    <div class="row">
        <div class="col-lg-8">
            @foreach ($post as $p)
            <div class="post-card mb-5">
                @if ($p->file_path)
                <a href="{{ route('post.show', $p->id) }}">
                    <img src="{{ $p->file_path }}" class="img-fluid rounded mb-3" alt="{{ $p->title }}">
                </a>
                @endif
                <div class="post-meta text-muted small mb-2">
                    <span>{{ $p->created_at->format('M d, Y') }}</span>
                </div>
                <h3 class="mb-2"><a href="{{ route('post.show', $p->id) }}" class="text-dark">{{ $p->title }}</a></h3>
                <p class="text-secondary">{{ \Illuminate\Support\Str::limit($p->content, 180) }}</p>
                <div class="d-flex align-items-center mt-3">
                    <a href="{{ route('post.show', $p->id) }}" class="btn btn-sm btn-outline-dark mr-2">Read more</a>
                    <form action="{{ route('post.destroy', $p->id) }}" method="post" class="mb-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-lg-4">
            <div class="sticky-top" style="top:20px;">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">About</h5>
                        <p class="text-muted small mb-0">A personal blog sharing stories, thoughts and ideas about life, tech and everything in between.</p>
                    </div>
                </div>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Search</h5>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search...">
                            <div class="input-group-append">
                                <button class="btn btn-dark" type="button">Go</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Recent Posts</h5>
                        <ul class="list-unstyled mb-0">
                            @foreach ($post as $p)
                            <li class="mb-2">
                                <a href="{{ route('post.show', $p->id) }}" class="text-dark">{{ \Illuminate\Support\Str::limit($p->title, 40) }}</a>
                                <div class="text-muted small">{{ $p->created_at->format('M d, Y') }}</div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection