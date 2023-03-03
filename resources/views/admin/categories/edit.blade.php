<div class="modal fade" id="edit-{{$category->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h4 class="text-dark">
                    <i class="fa-regular fa-pen-to-square"></i> Edit Category
                </h4>
            </div>
            <form action="{{route('admin.categories.update',$category->id)}}" method="post">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                
                <input type="text" name="category{{$category->id}}" class="form-control" placeholder="Edit a category..." value="{{old('category',$category->name)}}">
                @error('category')
                <p class="text-danger small">{{$message}}</p>
                @enderror
                
                </div>

                <div class="modal-footer">

                    <button type="button" data-bs-dismiss="modal" class="btn btn-outline-warning btn-sm">Cancel</button>
                    <button type="submit"  class="btn btn-warning btn-sm">Update</button>
                
                </div>
            </form>
        </div>
    </div>
</div>