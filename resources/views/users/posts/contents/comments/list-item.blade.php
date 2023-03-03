<div class="mb-2">
    <a href="{{ route('profile.show', $comment->user->id)}}" class="text-decoration-none fw-bold text-dark">
        {{ $comment->user->name }}
    </a>

    &nbsp;
    <span class="fw-light">{{ $comment->body }}</span>
    <br>
    <span class="text-muted xsmall">{{ date('D, M d Y', strtotime($comment->created_at)) }}</span>

    @if($comment->user->id == Auth::user()->id)
        &middot;
        {{-- dotの表示 --}}
        <form action="{{route('comment.delete',$comment->id)}}" method="post" class="d-inline">
            @csrf
            @method('DELETE')

            <button type="submit" class="border-0 p-0 shadow-none bg-transparent text-danger xsmall">Delete</button>
        </form>
    @endif
</div>