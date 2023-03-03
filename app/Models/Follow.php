<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    public $timestamps = false;

    //同じクラス名(User)で定義するとlaravelが混乱する(区別がつけられない)ため、第2引数にidを指定する。

    //自分のIDが入る
    public function follower(){
        return $this->belongsTo(User::class, 'follower_id')->withTrashed();
    }

    //フォローした相手のIDが入る
    public function followed(){
        return $this->belongsTo(User::class, 'followed_id')->withTrashed();
    }
}
