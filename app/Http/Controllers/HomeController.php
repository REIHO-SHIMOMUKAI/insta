<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
        //this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if($request->search){
            //検索フィルター
            $home_posts = $this->post->where( 'description','like','%'.$request->search.'%' )->latest()->get();
            //select * from posts WHERE description LIKE '%searchwords%'
            //[searchwords]が含まれる文字列をpostテーブルのdescriptionの中から探す
            //%はワイルドカード

            //(ユーザのフィルターはいらない)
        }else
        {
            $all_posts = $this->post->latest()->get();
            $home_posts=[];
            foreach($all_posts as $p){
                if( $p->user->id == Auth::user()->id || $p->user->isFollowed()){
                // postのユーザが自分自身 or フォローしてる人の投稿をTLに表示する
                $home_posts[] = $p;
                }
            }
        }

        return view('users.home')->with('all_posts',$home_posts)->with('suggested_users',$this->getSuggestedUsers())->with('search',$request->search);
    }

    private function getSuggestedUsers(){

        $all_users = $this->user->all()->except(Auth::user()->id);
        //get all users except login user

        $suggested_users = [];

        $count = 0;

        foreach($all_users as $u){
            if(!$u->isFollowed() && $count<10){
                // フォローしてない人を10人まで一覧にする
                $suggested_users[] = $u;
                $count++;
            }
        }

        return $suggested_users;
    }

    public function suggestedUsers(Request $request){

        $all_users = [];
        
        if($request->search_user){
            //search user boxに値が入っていたら
            $all_users = $this->user->where( 'name','like','%'.$request->search_user.'%' )->get()->except(Auth::user()->id);
        }
        else{

            $all_users = $this->user->all()->except(Auth::user()->id);
            //get all users except login user

        }

            $suggested_users = [];
    
            foreach($all_users as $u){
                if(!$u->isFollowed()){
                    // フォローしてない人を一覧にする
                    $suggested_users[] = $u;
                
                }
            }
        
        return view('users.suggested-users')->with('suggested_users',$suggested_users)->with('search_user',$request->search_user);
        //search user boxに値が入っているかどうかの情報をviewに渡したいので、$request->search_userを渡す
    }
}
