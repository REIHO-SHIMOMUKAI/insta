<div class="modal fade" id="like-user{{$post->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close text-primary" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                @foreach($post->likes as $like)
                <div class="row align-items-center mx-5 my-3">
                    
                    <div class="col-auto">
                        {{-- user icon --}}
                        <a href="{{ route('profile.show', $like->user->id)}}">
                            @if($like->user->avatar)
                            <img src="{{asset('storage/avatars/'.$like->user->avatar)}}" alt="" class="rounded-circle avatar-sm">
                            @else
                            <i class="fa-solid fa-circle-user icon-sm text-secondary"></i>
                            @endif
                        </a>
                    </div>

                    <div class="col">
                        {{-- user name --}}
                        <a href="{{ route('profile.show', $like->user->id)}}" class="text-decoration-none text-dark fw-bold">
                            {{$like->user->name}}
                        </a>
                    </div>

                    <div class="col-auto">
                        @if($like->user->id != Auth::user()->id)
                        {{-- 今ログインしているアカウントの場合はなにも表示しない --}}
                        @if($like->user->isFollowed())
                        {{-- if I follow this user --}}
                            <form action="{{route('follow.delete',$like->user->id)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="border-0 shadow-none bg-transparent p-0 text-secondary">Unfollow</button>
                            </form>
                        @else
                            <form action="{{route('follow.store',$like->user->id)}}" method="post">
                                @csrf

                                <button type="submit" class="border-0 shadow-none p-0 bg-transparent text-primary">Follow</button>
                            </form>
                        @endif

                    @endif
                    </div>
                    
                </div>
                @endforeach

            </div>

        </div>
    </div>
</div>