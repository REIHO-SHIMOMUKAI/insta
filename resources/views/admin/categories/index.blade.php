@extends('layouts.app')

@section('title','Admin: Categories')

@section('content')

<div class="mb-3">
<div class="position-relative">
    <div class="position-absolute top-0 start-0">
    <form action="{{route('admin.categories.create')}}" method="post">
        @csrf
        @method('PATCH')
        <div class="input-group">
        <input type="text" name="category" class="form-control" placeholder="Add a category..." value="{{old('category')}}">
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus"></i> Add</button>
        </div>
        @error('category')
        <p class="text-danger small">{{$message}}</p>
        @enderror
    </form>
    </div>

</div>
</div>
<table class="table table-hover align-middle text-secondary border text-center mt-5">
    <thead class="small table-warning text-uppercase text-secondary">
        <th>#</th>
        <th>Name</th>
        <th>Count</th>
        <th>Last updated</th>
        <th></th>
    </thead>
    <tbody>
        @forelse($all_categories as $category)
            <tr>
                <td>
                    {{$category->id}}
                </td>
                <td>
                    {{$category->name}}
                </td>
                <td>
                    {{-- count --}}
                    <?php $count=0; ?>
                    @foreach($category->categoryPosts as $category_post)
                    {{--Count how many rows matching category_id in the category_post teble (categories table's "id" and category_post table's "category_id" are primary key)--}}
                    <?php $count++;?>
                    @endforeach
                  {{$count}}
                </td>
                <td>
                    {{ $category->created_at }}
                </td>
                <td>
                    <button data-bs-toggle="modal" data-bs-target="#edit-{{$category->id}}" class="btn btn-sm border-rounded border-warning me-2"><i class="fa-solid fa-pen text-warning"></i></button>
                    <button data-bs-toggle="modal" data-bs-target="#delete-{{$category->id}}" class="btn btn-sm border-rounded border-danger"><i class="fa-solid fa-trash-can text-danger"></i></button>
                </td>
                @include('admin.categories.delete')
                @include('admin.categories.edit')
        @empty
        <tr>
            <td colspan="6" class="text-center text-muted">No categories found.</td>
        </tr>
        @endforelse
        <tr>
            <td>0</td>
            <td>Uncategorized</td>
            <td>{{$uncategorized_count}}</td>
        </tr>
    </tbody>
</table>



{{-- ページ下部に1,2...など出てくるようになる --}}
{{ $all_categories->links() }}
@endsection