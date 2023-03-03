@extends('layouts.app')

@section('title','Edit Profile')

@section('content')

<div class="row justify-content-center">
    <div class="col-8">
        <form action="{{ route('profile.update') }}" method="post" class="shadow bg-white p-5 mb-5 rounded-3" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <h2 class="h3 fw-light mb-3 text-muted">Update Profile</h2>

            <div class="row mb-3">
                <div class="col-4">
                    @if($user->avatar)
                    <img src="{{ asset('storage/avatars/'.$user->avatar) }}" alt="" class="rounded-circle d-block mx-auto image-lg">
                    @else
                    <i class="fa-solid fa-circle-user text-secondary icon-lg d-block text-center"></i>
                    @endif
                </div>

                <div class="col-auto align-self-end">
                    <input type="file" name="avatar" id="" class="form-control form-control-sm mt-2" aria-describedby="avatar-info">
                    <p class="form-text" id="avatar-info">
                        Acceptable formats: jpeg, jpg, png, gif only<br>
                        Max file size is 1048 KB
                    </p>
                    @error('avator')
                    <p class="text-danger small">{{$message}}</p>
                    @enderror
                </div>
            </div>

            <label for="name" class="form-label fw-bold">Name</label>
            <input type="text" name="name" value="{{old('name', $user->name)}}" id="name" class="form-control">
            @error('name')
            <p class="text-danger small">{{$message}}</p>
            @enderror

            <label for="email" class="form-label fw-bold mt-3">Email</label>
            <input type="email" name="email" value="{{old('email', $user->email)}}" id="email" class="form-control">
            @error('email')
            <p class="text-danger small">{{$message}}</p>
            @enderror

            <label for="introduction" class="form-label fw-bold mt-3">Introduction</label>
            <textarea name="introduction" id="introduction" rows="3" class="form-control">{{old('introduction', $user->introduction)}}</textarea>
            @error('introduction')
            <p class="text-danger small">{{$message}}</p>
            @enderror

            <button type="submit" class="btn btn-warning mt-4 px-4">Save</button>
        </form>

        <form action="{{route('profile.change-password')}}" method="post" class="mt-5 rounded-3 shadow p-5 bg-white">
            @csrf
            @method('PATCH')

            @if(session('success_message'))
            <p class="text-success fw-bold">{{session('success_message')}}</p>
            @endif

            <h2 class="h3 text-muted mb-3">Update Password</h2>

            <label for="old-password" class="form-label fw-bold">Old Password</label>
            <input type="password" name="old_password" id="old-password" class="form-control">
            @if(session('old_password_error'))
            <p class="text-danger small">{{session('old_password_error')}}</p>
            @endif

            <label for="new-password" class="form-label fw-bold mt-3">New Password</label>
            <input type="password" name="new_password" id="new-password" class="form-control">
            @if(session('same_password_error'))
            <p class="text-danger small">{{session('same_password_error')}}</p>
            @endif

            <label for="new-password-confirmation" class="form-label mt-3">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" id="new-password-confirmation" class="form-control">

            @error('new_password')
            <p class="text-danger small">{{$message}}</p>
            @enderror

            <button type="submit" class="btn btn-warning mt-4 px-4">Update Password</button>

        </form>
    </div>
</div>

@endsection