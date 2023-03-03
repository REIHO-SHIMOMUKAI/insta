@extends('layouts.app')

@section('title', 'Following')

@section('content')

@include('users.profiles.header')

<div class="mt-5 row justify-content-center">
    <div class="col-4">
        @if($user->followeds->isNotEmpty())
        {{-- if this user has following --}}
            <h3 class="text-center text-muted">Following</h3>
            @foreach($user->followeds as $followed)
            {{-- line up following this user has --}}
            {{-- このユーザのidがfollower_id(フォローしている側)に一致する行をとる --}}
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <a href="{{route('profile.show',$followed->followed->id)}}">
                  
                            @if($followed->followed->avatar)
                            <img src="{{asset('storage/avatars/'.$followed->followed->avatar)}}" alt="" class="rounded-circle avatar-sm">
                            @else
                            <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                            @endif
                        </a>
                    </div>

                    <div class="col">
                        <a href="{{route('profile.show',$followed->followed->id)}}" class="text-decoration-none text-dark fw-bold">
                        {{$followed->followed->name}}
                        </a>

                    </div>

                    <div class="col-auto">
                        @if($followed->followed->id != Auth::user()->id)
                            {{-- @if($followed->followed->isFollowed()) --}}
                            {{-- フォローしてる人しか表示しないのでこのif文いらない --}}
                                <form action="{{route('follow.delete',$followed->followed->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border-0 shadow-none bg-transparent p-0 text-secondary">Following</button>

                        @endif
                    </div>
                </div>
            @endforeach
        @else
        <h3 class="text-center text-muted">No following yet.</h3>
        @endif
    </div>
</div>

@endsection