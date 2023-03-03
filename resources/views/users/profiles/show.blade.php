@extends('layouts.app')

@section('title', 'Show Profile')

@section('content')

    @include('users.profiles.header')

    {{-- show posts --}}
    <div class="mt-5">
        <div class="row">
            @forelse($user->posts as $post)
            {{-- postsはUser.phpで最新順になるように定義されている --}}
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="{{ route('post.show',$post->id)}}">
                    <img src="{{asset('storage/images/'.$post->image)}}" alt="" class="grid-img">
                    </a>
                </div>
            @empty
                <p class="text-center text-muted">No posts yet.</p>
            @endforelse
        </div>
    </div>

@endsection