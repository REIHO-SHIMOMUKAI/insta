@extends('layouts.app')

@section('title','Show Post')

@section('content')

<style>
    .col-4{
        overflow-y:scroll;
    }    
    .card-body{
        position:absolute;
        /* 起点からどれだけ離れているかを指定できるようになる */
        top:65px;
    }
</style>

<div class="row border shadow">
    {{-- image --}}
    <div class="col border-end p-0">
        <img src="{{asset('storage/images/'.$post->image)}}" alt="" class="w-100">
    </div>

    {{-- image info --}}
    <div class="col-4 bg-white px-0">
        <div class="card border-0">
            @include('users.posts.contents.title')

            <div class="card-body w-100">
                @include('users.posts.contents.body')

                @include('users.posts.contents.comments.create')

                <div class="mt-3">
                    @foreach($post->comments as $comment)
                        @include('users.posts.contents.comments.list-item')
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>

@endsection