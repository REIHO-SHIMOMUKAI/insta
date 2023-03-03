@extends('layouts.app')

@section('title','Admin: Posts')

@section('content')


<div class="position-relative">
    <div class="position-absolute top-0 end-0 w-25">
    <form action="{{route('admin.posts')}}" method="get">
    
        <input type="text" name="search_description" placeholder="Search Description..." class="form-control form-control-sm mb-3" value="{{$search_description}}">
    
    </form>
    </div>
    </div>

<table class="table table-hover align-middle text-secondary border mt-5">
    <thead class="small table-primary text-uppercase text-secondary">
        <th></th>
        <th></th>
        <th>Category</th>
        <th>Owner</th>
        <th>Created At</th>
        <th>Status</th>
        <th></th>
    </thead>
    <tbody>
        @forelse($all_posts as $post)
            <tr>
                <td>
                    {{$post->id}}
                </td>
                <td>
                    <a href="{{ route('post.show',$post->id)}}">
                        <img src="{{asset('storage/images/'.$post->image)}}" alt="" class="image-lg">
                        </a>
                </td>
                <td>
                    {{-- category --}}
                    @forelse($post->categoryPosts as $category_post)
                        <div class="badge bg-secondary bg-opacity-50">{{$category_post->category->name}}</div>
                    @empty
                        <div class="badge bg-dark">Uncategorized</div>
                    @endforelse
                                        {{-- categoryPostsはarrayで値が入っている(Many to Manyのpivot tableになっている)ので、
                                            {{ $post->categoryPosts->category_id }} のようにして値は取れない。上記のようにforelseとかで回す必要がある。--}}
                </td>
                <td>
                    {{-- user name (owner) --}}
                    <a href="{{ route('profile.show',$post->user->id)}}" class="text-decoration-none text-dark fw-bold">
                    {{ $post->user->name }}
                    </a>
                </td>
                <td>
                    {{ $post->created_at }} 
                </td>
                <td>
                    {{-- status --}}
                    @if($post->trashed())
                    <i class="fa-sharp fa-solid fa-circle-minus"></i> Hidden
                    @else
                    <i class="fa-solid fa-circle text-primary"></i> Visible
                    @endif

                </td>
                <td>
                    {{-- dropdown --}}


                    <div class="dropdown">
                        <button data-bs-toggle="dropdown" class="btn btn-sm">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>

                        @if($post->trashed())
                        {{-- trashed - returns true if soft-deleted --}}
                        <div class="dropdown-menu">
                            <button data-bs-toggle="modal" data-bs-target="#unhide-{{$post->id}}" class="dropdown-item text-primary">
                                <i class="fa-solid fa-eye"></i> Unhide Post {{$post->id}}
                            </button>
                        </div>
                        @include('admin.posts.unhide')

                        @else
                        <div class="dropdown-menu">
                            <button data-bs-toggle="modal" data-bs-target="#hide-{{$post->id}}" class="dropdown-item text-danger">
                                <i class="fa-solid fa-eye-slash"></i> Hide Post {{$post->id}}
                            </button>
                        </div>
                        @include('admin.posts.hide')
                        @endif
                    </div>

                </td>
            </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center text-muted">No posts found.</td>
        </tr>
        @endforelse
    </tbody>
</table>

{{-- ページ下部に1,2...など出てくるようになる --}}
{{ $all_posts->links() }}
@endsection