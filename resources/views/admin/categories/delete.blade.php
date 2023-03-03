<div class="modal fade" id="delete-{{$category->id}}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h4 class="text-dark">
                    <i class="fa-solid fa-trash-can"></i> Delete Category
                </h4>
            </div>

            <div class="modal-body">
                Are you sure you want to delete <span class="fw-bold">{{$category->name}}</span> category?
                <br>
                <br>
                This action will affect all the posts under this category. Posts without a category will fall under Uncategorized.
            </div>

            <div class="modal-footer border-0">
                <form action="{{route('admin.categories.delete',$category->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" data-bs-dismiss="modal" class="btn btn-outline-danger btn-sm">Cancel</button>
                    <button type="submit"  class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>