<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    //
    const LOCAL_STRAGE_FOLDER = "public/images/";
    private $post;
    private $category;

    public function __construct(Post $post,Category $category){
        $this->post = $post;
        $this->category = $category;
    }

    public function create(){
        $all_categories = $this->category->all();

        return view('users.posts.create')->with('all_categories',$all_categories);
    }

    
    public function store(Request $request){
        $request->validate([
            'description' => 'required|max:1000',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1048',
            'categories' => 'required|array|between:1,3' 
            // between:1,3はarrayのサイズ(この場合3こまで)
        ]);

        $this->post->user_id = Auth::user()->id;
        $this->post->image = $this->saveImage($request);
        $this->post->description = $request->description;

        //posts tableに保存
        $this->post->save();

        $categ_post = [];
        foreach($request->categories as $categ_id){
            $categ_post[] = ['category_id' => $categ_id];
        }
        //create.bladeでcategories=[[1],[3]]のように値を入れられた場合、1周目は$categ_id=1,2周目は$categ_id=3

        //以下のように値が入る。
        // $categ_post=[
        //     [
        //         'category_id' => 1,
        //         'post_id' => 1
        //     ],
        //     [
        //         'category_id' => 2,
        //         'post_id' => 1
        //     ]
        //     ];
        //ここの処理ではpost_idに値は入れてないが、postテーブルのidなので、上の$this->post->user_idとかの処理を行うとidは自動的に1から順に割り振られるようになっている。postテーブルのidはcategory_postテーブルのpost_idと接続されているので、自動的にpost_idにも値が割り振られるようになっている。
        $this->post->categoryPosts()->createMany($categ_post);
        //createMany is built-in function
        //createManyはcreateの複数array版のメソッド。categoryPostsはcreate_postテーブルに接続するクラス名。(Eloquent)
    
        return redirect()->route('home');
    }

    private function saveImage($request){
        //make a new file name
        $file_name = time(). "." . $request->image->extension();

        //save the file into strage
        $request->image->storeAs(self::LOCAL_STRAGE_FOLDER, $file_name);

        return $file_name;
    }

    public function show($id){
        $post_a = $this->post->findOrFail($id);

        return view('users.posts.show')->with('post',$post_a);

    }

    public function edit($id){

        $post_a = $this->post->findOrFail($id);

        $all_categories = $this->category->all();

        // for check box
        $select_categories =[];
        foreach($post_a->categoryPosts as $category_post){
            $select_categories[] = $category_post->category_id;
        }
        //$post_a->categoryPosts:[post_id,category_id]=[1,1],[1,2]...の場合
        //1週目：$category_post=[1,1], $select_categories=[1]
        //2周目：$category_post=[1,2], $select_categories=[1,2]

        

        return view('users.posts.edit')->with('post',$post_a)->with('all_categories',$all_categories)->with('selected_categories',$select_categories);

    }

    public function update(Request $request, $id){
        $request->validate([
            'description' => 'required|max:1000',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1048',
            'categories' => 'required|array|between:1,3' 
            // between:1,3はarrayのサイズ(この場合3こまで)
        ]);

        $post_a = $this->post->findOrFail($id);

        $post_a->description = $request->description;

        // check if there is an image file in the form
        if($request->image){
            //delete the current file
            $this->deleteImage($post_a->image);
            //save new file, and file name
            $post_a->image = $this->saveImage($request);
        }

        $post_a->save();

        //対象postのcategory postテーブルを削除してもう一度作り直す
        $post_a->categoryPosts()->delete();

        $categ_post = [];
        foreach($request->categories as $categ_id){
            $categ_post[] = ['category_id' => $categ_id];
        }

        $post_a->categoryPosts()->createMany($categ_post);

        return redirect()->route('post.show',$id);
    }

    private function deleteImage($file_name){
        $image_path = self::LOCAL_STRAGE_FOLDER . $file_name;

        if(Storage::disk('local')->exists($image_path)){
            Storage::disk('local')->delete($image_path);
        }


    }

    public function delete($id){

        $post_a = $this->post->findOrFail($id);

        if($post_a->image){
            //delete the current file
            $this->deleteImage($post_a->image);
        }

        //delete post
        //$this->post->destroy($id);
        //$post_a->delete()でもいい

        //上記のdestroyなどを使うと投稿はsoftdeleteするようになってしまっているため、ユーザが個人で投稿削除した場合は強制的に完全削除する
        $post_a->forceDelete();

        return redirect()->route('home');
    }
}