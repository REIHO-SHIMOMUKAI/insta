@extends('layouts.app')

@section('title','Edit Post')

@section('content')

<form action="{{route('post.update',$post->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <p class="fw-bold d-block">Category <span class="fw-normal text-muted">(up to 3)</span></p>
    <div>
        @foreach($all_categories as $category)
        <div class="form-check form-check-inline">
            @if(in_array($category->id, $selected_categories))
            {{-- in_array:第2引数のarrayに第1引数の値が存在するか 
                $selected_categoriesに$category->idが存在する場合TRUE--}}
                <input type="checkbox" name="categories[]" id="{{$category->name}}" value="{{ $category->id }}" class="form-check-input" checked>
            @else
                <input type="checkbox" name="categories[]" id="{{$category->name}}" value="{{ $category->id }}" class="form-check-input">
            @endif
            <label for="{{$category->id}}" class="form-check-label">{{$category->name}}</label>
        </div>
        {{-- value="{{old('categories',$post->categoryPosts->category_id)}}"  --}}
        @endforeach
        @error('categories')
        <p class="small text-danger">{{ $message }}</p>
        @enderror
    </div>

    <label for="description" class="form-label fw-bold mt-3">Decription</label>
    <textarea name="description" id="description" cols="30" rows="3" class="form-control" placeholder="What's on your mind">{{old('description',$post->description)}}</textarea>
    @error('description')
    <p class="small text-danger">{{ $message }}</p>
    @enderror

    <div class="w-50">
        <label for="image" class="form-label fw-bold mt-3">Image</label>
        <img src="{{asset('storage/images/'.$post->image)}}" alt="" class="w-100 img-thumbnail">
        <input type="file" name="image" id="image" class="form-control" aria-describedby="image-info" value="{{old('image',$post->image)}}">
        <p class="form-text" id="image-info">
            Acceptable formats:jpeg, jpg, png, gif only<br>
            Max size is 1048 KB
        </p>
        @error('image')
        <p class="small text-danger">{{ $message }}</p>
        @enderror
    </div>
    

    <button type="submit" class="btn btn-warning mt-4 px-3">Post</button>
</form>

@endsection