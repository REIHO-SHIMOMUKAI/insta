<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    //
    private $comment;

    public function __construct(Comment $comment){
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id){

        $request->validate([
            'comment_body'.$post_id => 'required|max:200' 
        ],
        [ //validation rule
            'comment_body'.$post_id.".required" => 'Cannot submit an empty comment',
            //It looks like to "comment_body2.required", So "." is necesary before "required"
            'comment_body'.$post_id.".max" => 'Comment must not be longer than 200 charactors'
        ]);

        $this->comment->user_id = Auth::user()->id;
        $this->comment->post_id = $post_id;
        $this->comment->body = $request->input('comment_body'.$post_id);
        // $request->'comment_body'.$post_idのようにはできないので、inputをつかう
        $this->comment->save();

        return redirect()->back();
    }

    
    public function delete($id){

        $comment_a = $this->comment->findOrFail($id);

        //delete comment
        $comment_a->delete();
        

        return redirect()->back();
    }
}
