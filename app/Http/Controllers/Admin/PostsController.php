<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    private $post;

    public function __construct(Post $post){
        $this->post = $post;
    }

    public function index(Request $request){

        if($request->search_description){
            //search description boxに値が入っていたら
    
            $all_posts = $this->post->where('description','like','%'.$request->search_description.'%' )->withTrashed()->latest()->paginate(10);
    
        }else{
            $all_posts = $this->post->withTrashed()->latest()->paginate(10);
            //paginate - returns paged data
            //withTrashed - includes soft-deleted records
        }

        return view('admin.posts.index')->with('all_posts', $all_posts)->with('search_description',$request->search_description);
    }

    public function hide($id){
        $this->post->destroy($id);

        return redirect()->back();
    }

    public function unhide($id){

        $this->post->onlyTrashed()->findOrFail($id)->restore();

        //onlyTrashed - only looks at soft-deleted records
        //restore() - undoes a soft delete

        return redirect()->back();
    }
}
