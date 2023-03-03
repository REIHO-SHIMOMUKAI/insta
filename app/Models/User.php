<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    const ADMIN_ROLE_ID = 1;
    const USER_ROLE_ID = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(){
        return $this->hasMany(Post::class)->latest();
        // latest：最新順で投稿をとってくる
    }

    public function comments(){
        return $this->hasMany(Comment::class)->latest();
    }

    // user has many followers
    public function followers(){
        return $this->hasMany(Follow::class,'followed_id');
        //ユーザにフォローされた人を指すので、followed_id
    }

    // the people users followed
    public function followeds(){
        return $this->hasMany(Follow::class,'follower_id');
        //ユーザがフォローした人を指すので、follower_id
    }

    //return true or false
    //ログインユーザにフォローされているかどうか
    public function isFollowed(){
        //今ログインしているユーザがfollower_idになっている行を探し、あったらtrueを返す
        return $this->followers()->where('follower_id',Auth::user()->id)->exists();
        //例：$post->user->isFollowed()で呼ばれた場合
        //その投稿のユーザidとfollowers()(followed_id)(フォローされている側)が一致している物を探す
        //そのあとwhere('follower_id',Auth::user()->id)でフォローしているユーザがログインしているユーザに一致しているかどうかを探す
        //例：ユーザ1(id:1)がログインユーザ(id:4)をフォローしているか
        //$this->followers()でid:1に一致するfollowテーブルのfollowed_idの行(followed_id:1の行)を取り出す。
        //where('follower_id',Auth::user()->id)でさらにfollowed_id:1の行の中からfollower_id:4に一致する行を呼び出す。
        //あればexists=trueで返る。
    }

    //ログインユーザをフォローしているかどうか
    public function isFollowing(){
        //今ログインしているユーザがfollowed_idになっている行を探し、あったらtrueを返す
        return $this->followeds()->where('followed_id',Auth::user()->id)->exists();
        //$this->followeds():ユーザがフォローしてる側(follower_id)にあるデータ
        //$this->followeds()->where('followed_id',Auth::user()->id):上記の中からログインユーザがフォローされている側にあるデータを探す
    }
}
