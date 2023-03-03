@extends('layouts.app')

@section('title', 'Followers')

@section('content')

@include('users.profiles.header')

<div class="mt-5 row justify-content-center">
    <div class="col-4">
        @if($user->followers->isNotEmpty())
        {{-- このユーザのidがfollowテーブルのfollowed_id(フォローされてる側)に入っている場合 --}}
            <h3 class="text-center text-muted">Followers</h3>
            @foreach($user->followers as $follower)
            {{-- このユーザがfollowed_id(フォローされている側)に一致する行をとる --}}
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <a href="{{route('profile.show',$follower->follower->id)}}">
                            {{-- 1番目のfollowerはforeachの$follower(followテーブルの中でこのユーザが持っているfollowerを一回ずつ取り出して回している)。2番目のfollowerはUserクラス(Follow.php)のメソッド。usersテーブルのidを取り出す。 $follower->followerには、このユーザをフォローしているユーザの情報が入っている。--}}
                            @if($follower->follower->avatar)
                            <img src="{{asset('storage/avatars/'.$follower->follower->avatar)}}" alt="" class="rounded-circle avatar-sm">
                            @else
                            <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                            @endif
                        </a>
                    </div>

                    <div class="col">
                        <a href="{{route('profile.show',$follower->follower->id)}}" class="text-decoration-none text-dark fw-bold">
                        {{$follower->follower->name}}
                        </a>

                    </div>

                    <div class="col-auto">
                        @if($follower->follower->id != Auth::user()->id)
                            @if($follower->follower->isFollowed())
                            {{-- このユーザをフォローしているユーザにフォローされてるか(相互フォローか)どうか --}}
                                <form action="{{route('follow.delete',$follower->follower->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border-0 shadow-none bg-transparent p-0 text-secondary">Following</button>
                                </form>
                            @else
                                <form action="{{route('follow.store',$follower->follower->id)}}" method="post">
                                    @csrf

                                    <button type="submit" class="border-0 shadow-none p-0 bg-transparent text-primary">Follow</button>
                                </form>
                            @endif

                        @endif
                    </div>
                </div>
            @endforeach
        @else
        <h3 class="text-center text-muted">No followers yet.</h3>
        @endif
    </div>
</div>

@endsection