@extends('layouts.app')

@section('title','Suggested Users')

@section('content')

<div class="row justify-content-center">
    <div class="col-6">

        <form action="{{route('suggested-users')}}" method="get">
            {{-- getを使う場合、@csrfはいらない。プライバシーを守る必要がないから。 --}}
            <input type="text" name="search_user" placeholder="Search User..." class="form-control form-control-sm mb-3">
        </form>

        @if($search_user)
        {{-- search userボックスに値が入っていたら --}}
            @if(count($suggested_users) == 0)
            {{-- 検索結果がなかったら --}}
            {{-- $suggested_usersはphp arrayなので、$suggested_users->count()のようにはできない(HomeController.phpではall()で取得してるから) --}}
                <h5 class="text-muted mb-3">No searched user found.</h5>
            @else

            @endif
        @endif

        @foreach($suggested_users as $user)

        <div class="row mb-3 align-items-center mx-5">
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
                {{ $user->name }}</a><br>
                {{ $user->email }} <br>
                @if($user->isFollowing())
                {{-- ログインユーザをフォローしているかどうか --}}
                {{-- このユーザにfollowされてたらfollows youと出る --}}
                follows you
                @else
                {{-- followされてなかったらフォロワー数が表示される --}}
                    @if($user->followers->count()>0)
                    {{-- This user have follower --}}
                    <span class="fw-bold">{{$user->followers->count()}}</span>
                    &nbsp;
                    {{ $user->followers->count() == 1 ? 'follower' : 'followers' }}
                    @else
                    {{-- 0 follower --}}
                    No followers yet
                    @endif
                @endif
            </div>
            <div class="col-auto">
                <form action="{{route('follow.store',$user->id)}}" method="post">
                @csrf
                <button type="submit" class="btn btn-primary">Follow</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>



@endsection