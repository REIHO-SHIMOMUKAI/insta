@extends('layouts.app')

@section('title','Admin: Users')

@section('content')


<div class="position-relative">
<div class="position-absolute top-0 end-0 w-25">
<form action="{{route('admin.users')}}" method="get">

    <input type="text" name="search_user" placeholder="Search User..." class="form-control form-control-sm mb-3" value="{{$search_user}}">

</form>
</div>
</div>

<table class="table table-hover align-middle text-secondary border mt-5">
    <thead class="small table-success text-uppercase text-secondary">
        <th></th>
        <th>Name</th>
        <th>Email</th>
        <th>Created At</th>
        <th>Status</th>
        <th></th>
    </thead>
    <tbody>
        @forelse($all_users as $user)
            <tr>
                <td>
                    @if($user->avatar)
                    <img src="{{asset('storage/avatars/'.$user->avatar)}}" alt="" class="rounded-circle avatar-md d-block mx-auto">
                    @else
                    <i class="fa-solid fa-circle-user text-secondary icon-md d-block text-center"></i>
                    @endif
                </td>
                <td>
                    <a href="{{route('profile.show', $user->id)}}" class="text-decoration-none fw-bold text-dark">{{ $user->name }}</a>
                </td>
                <td>
                    {{ $user->email }}
                </td>
                <td>
                    {{ $user->created_at }}
                </td>
                <td>
                    @if($user->id != Auth::user()->id)
                    {{-- 自分のときはドロップダウンできない --}}
                    @if($user->trashed())
                    {{-- trashed - returns true if soft-deleted --}}
                    <i class="fa-regular fa-circle"></i> Inactive
                    @else
                    <i class="fa-solid fa-circle text-success"></i> Active
                    @endif
                </td>
                <td>
                    @if($user->trashed())
                    <div class="dropdown">
                        <button data-bs-toggle="dropdown" class="btn btn-sm">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>

                        <div class="dropdown-menu">
                            <button data-bs-toggle="modal" data-bs-target="#activate-{{$user->id}}" class="dropdown-item">
                                <i class="fa-solid fa-user-check"></i> Activate {{$user->name}}
                            </button>
                        </div>
                    </div>
                    @include('admin.users.activate')
                    @else
                    <div class="dropdown">
                        <button data-bs-toggle="dropdown" class="btn btn-sm">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>

                        <div class="dropdown-menu">
                            <button data-bs-toggle="modal" data-bs-target="#deactivate-{{$user->id}}" class="dropdown-item text-danger">
                                <i class="fa-solid fa-user-slash"></i> Deactivate {{$user->name}}
                            </button>
                        </div>
                    </div>

                    @include('admin.users.deactivate')
                    @endif
                    @endif

                </td>
            </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center text-muted">No users found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- ページ下部に1,2...など出てくるようになる --}}
{{ $all_users->links() }}
@endsection