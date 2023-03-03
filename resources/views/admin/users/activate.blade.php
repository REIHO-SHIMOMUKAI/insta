<div class="modal fade" id="activate-{{$user->id}}">

    <div class="modal-dialog">
        <div class="modal-content border-success">
            <div class="modal-header border-success">
                <h4 class="text-success">
                <i class="fa-solid fa-user-check"></i> Activate User
                </h4>
            </div>

            <div class="modal-body">
                Are you sure you want to activate <span class="fw-bold">{{$user->name}}</span> ?
            </div>

            <div class="modal-footer border-0">
                <form action="{{route('admin.users.activate',$user->id)}}" method="post">
                    @csrf
                    @method('PATCH')

                    <button type="button" data-bs-dismiss="modal" class=" btn btn-sm btn-outline-success">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success">Activate</button>
                </form>
                
            </div>
        </div>
    </div>
</div>