<div class="card-header bg-white py-3">
    <div class="row align-items-center">
        <div class="col-auto">
            <a href="{{ route('profile.show', $post->user->id)}}">
                @if($post->user->avatar)
                <img src="{{asset('storage/avatars/'.$post->user->avatar)}}" alt="" class="rounded-circle avatar-sm">
                @else
                <i class="fa-solid fa-circle-user icon-sm text-secondary"></i>
                @endif
            </a>
        </div>

        <div class="col ps-0">
            <a href="{{ route('profile.show', $post->user->id)}}" class="text-decoration-none text-dark">
                {{ $post->user->name }}
            </a>
        </div>

        <div class="col-auto">
            @if($post->user_id == Auth::user()->id)
            {{-- 投稿しているユーザがログインユーザだった場合 --}}
            <div class="dropdown">
                <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-ellipsis"></i>
                </button>

                <div class="dropdown-menu">
                    <a href="{{route('post.edit',$post->id)}}" class="dropdown-item"><i class="fa-regular fa-pen-to-square"></i>Edit</a>

                    <button data-bs-toggle="modal" data-bs-target="#delete-post{{$post->id}}" class="dropdown-item text-danger"><i class="fa-regular fa-trash-can"></i>Delete</button>
                </div>
            </div>
            @include('users.posts.contents.modals.delete')

            @else
            {{-- 投稿しているユーザがログインユーザじゃない場合 --}}
                @if($post->user->isFollowed())
                {{-- もしすでにフォロー済みのユーザーだったら
                    $post->userはuser_idを外部キーとしている --}}
                <form action="{{route('follow.delete', $post->user->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="shadow-none border-0 p-0 bg-transparent text-secondary">Unfollow</button>
                </form>

                @else
                {{-- まだフォローしていないユーザの場合 --}}
                <form action="{{route('follow.store',$post->user->id)}}" method="post">
                    @csrf
                    <button type="submit" class="shadow-none border-0 p-0 bg-transparent text-primary">Follow</button>
                </form>
                @endif
            @endif

        </div>
    </div>
</div>