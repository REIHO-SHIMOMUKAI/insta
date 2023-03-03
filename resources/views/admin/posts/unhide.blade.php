<div class="modal fade" id="unhide-{{$post->id}}">

    <div class="modal-dialog">
        <div class="modal-content border-primary">
            <div class="modal-header border-primary">
                <h4 class="text-primary">
                    <i class="fa-solid fa-eye"></i> Unhide Post
                </h4>
            </div>

            <div class="modal-body">
                Are you sure you want to unhide this post?
                <br>
                <img src="{{asset('storage/images/'.$post->image)}}" alt="" class="image-lg my-3">
                <br>
                {{$post->description}}
            </div>

            <div class="modal-footer border-0">
                <form action="{{route('admin.posts.unhide',$post->id)}}" method="post">
                    @csrf
                    @method('PATCH')
                    <button type="button" data-bs-dismiss="modal" class="btn btn-outline-primary btn-sm">Cancel</button>
                    <button type="submit"  class="btn btn-primary btn-sm">Unhide</button>
                </form>
            </div>
        </div>
    </div>
</div>