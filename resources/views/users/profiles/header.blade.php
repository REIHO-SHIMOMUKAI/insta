<div class="row mb-5">
    <div class="col-3">
        <a class="btn" data-bs-toggle="modal" data-bs-target="#comment{{$user->id}}">
        @if($user->avatar)
            <img src="{{ asset('storage/avatars/'.$user->avatar) }}" alt="" class="rounded-circle d-block mx-auto image-lg">
        {{-- mx-autoはtext-centerみたいなもの --}}
        @else
            <i class="fa-solid fa-circle-user text-secondary icon-lg d-block text-center"></i>
        @endif
        </a>
    </div>

    <div class="col-8">
        <div class="row mb-3">
            <div class="col-auto">
                <h2 class="display-6 mb-0">{{ $user->name }}</h2>
            </div>

            <div class="col-auto p-2">
                @if($user->id == Auth::user()->id)
                    {{-- edit profile --}}
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary">Edit Profile</a>
                @else
                    @if($user->isFollowed())
                    {{-- もしすでにフォロー済みの場合 --}}
                    <form action="{{route('follow.delete', $user->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-secondary">Unfollow</button>

                    </form>

                    @else
                    <form action="{{route('follow.store',$user->id)}}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary">Follow</button>
                    </form>
                    @endif
                @endif
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-auto">
                <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark">
                    <span class="fw-bold">{{ $user->posts->count() }}</span>
                    &nbsp;
                    {{ $user->posts->count() == 1 ? 'post' : 'posts' }}
                    {{-- IF statement ? true : false --}}
                </a>
            </div>
            <div class="col-auto">
                <a href="{{route('profile.followers',$user->id)}}" class="text-decoration-none text-dark">
                    <span class="fw-bold">{{$user->followers->count()}}</span>             &nbsp;
                    {{ $user->followers->count() == 1 ? 'follower' : 'followers' }}
                </a>
            </div>
            <div class="col-auto">
                <a href="{{route('profile.following',$user->id)}}" class="text-decoration-none text-dark">
                    <span class="fw-bold">{{$user->followeds->count()}}</span> following
                </a>
            </div>
        </div>

        <p class="mb-3">{{ $user->introduction }}</p>
    </div>
</div>

@include('users.profiles.modal')
