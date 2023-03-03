<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;

class FollowController extends Controller
{
    //
    private $follow;

    public function __construct(Follow $follow){
        $this->follow = $follow;
    }

    // $uid is the person I want to follow
    public function store($uid){
        //フォローしてる側(自分)のユーザIDをデータベースに入れる
        $this->follow->follower_id = Auth::user()->id;
        //フォローされてる側(相手)のユーザIDをデータベースに入れる
        $this->follow->followed_id = $uid;

        $this->follow->save();

        return redirect()->back();
    }

    public function delete($uid){
        //delete()
        $this->follow->where('follower_id',Auth::user()->id)->where('followed_id',$uid)->delete();

        return redirect()->back();
    }
}
