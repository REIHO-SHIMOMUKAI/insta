@extends('layouts.app')

@section('title','Create Post')

@section('content')

<form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <p class="fw-bold d-block">Category <span class="fw-normal text-muted">(up to 3)</span></p>
    <div>
        @foreach($all_categories as $category)
        <div class="form-check form-check-inline">
            <input type="checkbox" name="categories[]" id="{{$category->name}}" value="{{$category->id}}" class="form-check-input">
            <label for="{{$category->id}}" class="form-check-label">{{$category->name}}</label>
        </div>
        {{-- Categoryタグ選択でTravelとLifestyleを選んだら、categories=[[1],[3]]で渡される(PostController.phpのstoreで読まれる) --}}
        @endforeach
        @error('categories')
        {{-- errorの中身はPostController.phpのstoreのvalidate関数でチェックしている名前と一緒 --}}
        <p class="small text-danger">{{ $message }}</p>
        @enderror
    </div>

    <label for="description" class="form-label fw-bold mt-3">Decription</label>
    <textarea name="description" id="description" cols="30" rows="3" class="form-control" placeholder="What's on your mind">{{old('description')}}</textarea>
    @error('description')
    <p class="small text-danger">{{ $message }}</p>
    @enderror

    <label for="image" class="form-label fw-bold mt-3">Image</label>
    <input type="file" name="image" id="image" class="form-control" aria-describedby="image-info">
    <p class="form-text" id="image-info">
        Acceptable formats:jpeg, jpg, png, gif only<br>
        Max size is 1048 KB
    </p>
    @error('image')
    <p class="small text-danger">{{ $message }}</p>
    @enderror

    <button type="submit" class="btn btn-primary mt-4 px-3">Post</button>
</form>

@endsection