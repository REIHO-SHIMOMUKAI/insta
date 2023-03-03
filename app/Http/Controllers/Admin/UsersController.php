<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function index(Request $request){

        if($request->search_user){
        //search user boxに値が入っていたら

            $all_users = $this->user->where( 'name','like','%'.$request->search_user.'%' )->withTrashed()->latest()->paginate(10);

        }else{

            $all_users = $this->user->withTrashed()->latest()->paginate(10);
            //paginate - returns paged data
            //withTrashed - includes soft-deleted records

        }


        return view('admin.users.index')->with('all_users', $all_users)->with('search_user',$request->search_user);
    }

    public function deactivate($id){
        $this->user->destroy($id);

        return redirect()->back();
    }

    public function activate($id){

        $this->user->onlyTrashed()->findOrFail($id)->restore();

        //onlyTrashed - only looks at soft-deleted records
        //restore() - undoes a soft delete

        return redirect()->back();
    }
}
