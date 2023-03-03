<div class="modal fade" id="hide-{{$post->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h4 class="text-danger">
                    <i class="fa-solid fa-eye-slash"></i> Hide Post
                </h4>
            </div>

            <div class="modal-body">
                Are you sure you want to hide this post?
                <br>
                <img src="{{asset('storage/images/'.$post->image)}}" alt="" class="image-lg my-3">
                <br>
                {{$post->description}}
            </div>

            <div class="modal-footer border-0">
                <form action="{{route('admin.posts.hide',$post->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" data-bs-dismiss="modal" class="btn btn-outline-danger btn-sm">Cancel</button>
                    <button type="submit"  class="btn btn-danger btn-sm">Hide</button>
                </form>
            </div>
        </div>
    </div>
</div>