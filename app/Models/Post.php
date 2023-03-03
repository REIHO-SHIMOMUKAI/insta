<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes;

    public function categoryPosts(){
        return $this->hasMany(CategoryPost::class);
    }

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
        //softdeleteされたデータも含む
        //postはuserクラスに属するので、userをソフトデリートしたとしても、データとしては残してあつかう。
        //(postからソフトデリートしたuserを扱えるようにしておく)
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    // return true or false
    public function isLiked(){
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
        // $this->likes() -- gets all likes related to the the post
        // where(...) -- finds likes by logged-in user
        // exists() -- returns true if there are records found

        // likesテーブルのなかでログイン中のuser_idに一致する行を探し、あったらtrueを返す処理
    }
}
