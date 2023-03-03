
    <div class="row align-items-center">
        {{-- heart button --}}
        <div class="col-auto">
            @if($post->isLiked())
            {{-- この投稿に対してハートをすでに押していたら、もう一度クリックしたときにハートを外す --}}
            <form action="{{route('like.delete',$post->id)}}" method="post">
                @csrf
                @method('DELETE')

                <button type="submit" class="shadow-none bg-transparent border-0 p-0 text-danger"><i class="fa-solid fa-heart"></i></button>

            </form>
            @else
            <form action="{{ route('like.store',$post->id) }}" method="post">
                @csrf

                <button type="submit" class="shadow-none bg-transparent border-0 p-0 text-dark"><i class="fa-regular fa-heart"></i></button>
            </form>
            @endif
        </div>

        {{-- no. of likes --}}
        <div class="col-auto px-0">
            @if($post->likes->count() > 0)
            {{-- if [no. of likes] is more than 0, turn it into a button to open the modal --}}
            <a class="btn" data-bs-toggle="modal" data-bs-target="#like-user{{$post->id}}">{{$post->likes->count()}}</a>
            @else
            {{$post->likes->count()}}
            @endif
        </div>

        @include('users.posts.contents.modals.likes')

        {{-- categories --}}
        <div class="col text-end">
            @forelse($post->categoryPosts as $category_post)
            {{-- forelseではデータが空の時の処理を簡単に書くことができる --}}
            {{-- $category_postにはcategory_postテーブルの行が入っている(home.bladeで全てのpostを順に回しているので、もしpost_id=1だったらそれに対応するcategory_idも$category_postに入る。$category_post=[1,1]のような形。)
            post_id=2に対して、category_id=1,2が入っていたら、$category_post=[2,1] ,[2,2]が順番に回される。--}}
            <div class="badge bg-secondary bg-opacity-50">{{$category_post->category->name}}</div>
            {{-- $category_post->category->nameで対応するcategoriesテーブルのnameがとれる。 --}}


            @empty
            {{-- Adminはcategoryを削除できるので、ここを通る場合もある --}}
            <div class="badge bg-dark">Uncategorized</div>
            @endforelse
        </div>
    </div>

    <a href="{{ route('profile.show', $post->user->id)}}" class="text-decoration-none fw-decoration-none fw-bold text-dark">{{ $post->user->name }}</a>
    &nbsp; 
    {{-- 改行の禁止をする半角スペース --}}

    <span class="fw-light">{{ $post->description }}</span>
    <p class="text-muted xsmall text-uppercase">{{ date('M d, Y', strtotime($post->created_at)) }}</p>




