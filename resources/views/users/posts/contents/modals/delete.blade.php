<div class="modal fade" id="delete-post{{$post->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger text-danger">
                <h4>Delete Post</h4>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to delete this post?</p>
                <img src="{{asset('storage/images/'.$post->image)}}" alt="" class="image-lg">
                {{-- image-lg: css style(public/css/style.css) --}}
                <p class="text-muted">{{$post->description}}</p>
                {{-- users/home.blade.phpでこのファイルをincludeしているので、$postが使える。 --}}
            </div>

            <div class="modal-footer border-0">
                <form action="{{route('post.delete',$post->id)}}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-outline-danger">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>

            </div>
        </div>
    </div>
</div>