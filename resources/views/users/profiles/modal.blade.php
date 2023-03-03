<div class="modal fade" id="comment{{$user->id}}">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content border-dark">
            <div class="modal-header border-dark text-secondary">
                <h4>Recent Comments</h4>
            </div>

            <div class="modal-body">
                @foreach($user->comments->take(5) as $comment)
                {{-- 上から5個まで表示 --}}
                <div class="card border-info mt-3 text-secondary">
                    <div class="mx-3 my-3">
                        {{$comment->body}}
                        <hr>
                        Replied to <a href="{{route('post.show',$comment->post_id)}}" class="text-decoration-none">
                            {{-- $comment->post_id：commentテーブルのpost_idをパスに入れる--}}
                            {{$comment->post->user->name}}</a>
                            {{-- commentテーブルにある投稿(post_id)の投稿者を表示したい --}}
                            {{-- commentからpostを取り出し、postからuser(投稿者)の情報を取り出す --}}
                    </div>
                </div>
                @endforeach

            </div>

            <div class="modal-footer border-0">
                <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-secondary">Close</button>
            </div>
        </div>
    </div>
</div>