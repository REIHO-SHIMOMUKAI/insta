<form action="{{route('comment.store',$post->id)}}" method="post" class="d-block mt-3">
    @csrf
    <div class="input-group">
        <textarea name="comment_body{{ $post->id }}" id="" rows="1" class="form-control form-control-sm" placeholder="Write a comment...">{{ old('comment_body'.$post->id) }}</textarea>
        <button type="submit" class="btn btn-sm btn-outline-secondary">Post</button>
    </div>
    @error('comment_body'.$post->id)
    <p class="text-danger small">{{ $message }}</p>
    @enderror

</form>