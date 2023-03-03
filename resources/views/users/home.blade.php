@extends('layouts.app')

@section('title','Home')

@section('content')
<div class="row gx-5">
    {{-- POSTS --}}
    <div class="col-8">
        @if($search)
        {{-- searchボックスに値が入っていたら --}}
            @if($all_posts->count() == 0)
            {{-- 検索結果がなかったら --}}
                <h5 class="text-muted mb-3">No search found.</h5>
            @else
                <h5 class="text-muted mb-3">Search results for<span class="fw-bold"> '{{$search}}' </span></h5>
            @endif
        @endif

        @forelse($all_posts as $post)
        {{-- All posts are looped --}}
        <div class="card mb-4">
            {{-- title --}}
            @include('users.posts.contents.title')

            {{-- image --}}
            <div class="container p-0">
                <a href="{{route('post.show', $post->id)}}">
                    <img src="{{asset('storage/images/'.$post->image)}}" alt="" class="w-100">
                </a>
            </div>

            {{-- body --}}
            <div class="card-body">
                @include('users.posts.contents.body')

                <hr class="mt-3">

                <div class="mt-3">
                    @foreach($post->comments->take(3) as $comment)
                    {{-- 3つまで表示 --}}
                        @include('users.posts.contents.comments.list-item')
                    @endforeach

                    @if($post->comments->count() > 3)
                        <a href="{{route('post.show',$post->id)}}" class="text-decoration-none small">View all {{ $post->comments->count() }} comments</a>
                    @endif
                </div>

                @include('users.posts.contents.comments.create')
            </div>
        </div>
        
        @empty
        {{-- post is empty --}}
        <div class="text-center">
            <h2>Shere Photos</h2>
            <p class="text-muted">When you shere photos, they'll appear on your profile.</p>
            <a href="{{route('post.create')}}" class="text-decoration-none">Share your first photo</a>
        </div>
        @endforelse

    </div>

    {{-- USER/SUGGESTIONS --}}
    <div class="col-4">
        <div class="row shadow-sm rounded-3 mb-5 align-items-start">
            <div class="col-auto">
                <a href="{{ route('profile.show',Auth::user()->id) }}">
                    @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/avatars/'.Auth::user()->avatar) }}" alt="" class="rounded-circle avatar-md">
                    @else
                    <i class="fa-solid fa-circle-user text-secondary icon-md"></i>
                    @endif
                </a>
            </div>
            <div class="col ps-0">
                <a href="{{ route('profile.show',Auth::user()->id) }}" class="text-decoration-none text-dark fw-bold">
                    {{ Auth::user()->name }}
                </a>
            <p class="text-muted">{{ Auth::user()->email }}</p>
            </div>
        </div>

        {{-- SUGGESTIONS --}}
        <div class="row mt-5 mb-3">
            <div class="col text-secondary fw-bold">
                Suggestions For You
            </div>
            <div class="col-auto">
                <a href="{{route('suggested-users')}}" class="text-decoration-none fw-bold text-dark">See all</a>
            </div>
        </div>

        @foreach($suggested_users as $user)
            <div class="row mb-3 align-items-center">
                <div class="col-auto">
                    <a href="{{route('profile.show', $user->id)}}" class="">
                        @if($user->avatar)
                        <img src="{{ asset('storage/avatars/'.$user->avatar) }}" alt="" class="rounded-circle avatar-sm">
                        @else
                        <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                        @endif
                    </a>
                </div>
                <div class="col">
                    <a href="{{route('profile.show', $user->id)}}" class="text-decoration-none fw-bold text-dark">
                    {{ $user->name }}</a>
                </div>
                <div class="col-auto">
                    <form action="{{route('follow.store',$user->id)}}" method="post">
                    @csrf
                    <button type="submit" class="border-0 shadow-none bg-transparent p-0 text-primary">Follow</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection