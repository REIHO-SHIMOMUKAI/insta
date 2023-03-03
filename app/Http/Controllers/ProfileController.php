<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{

    const LOCAL_STORAGE_FOLDER ='public/avatars/';
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function show($id){
        $user_a = $this->user->findOrFail($id);
        return view('users.profiles.show')->with('user',$user_a);
    }

    public function edit(){
        $user_a = $this->user->findOrFail(Auth::user()->id);

        return view('users.profiles.edit')->with('user',$user_a);
    }

    public function update(Request $request){

        $request->validate([
            'avatar' => 'max:1048|mimes:jpeg,jpg,png,gif',
            'name' => 'required|max:50',
            'email' => 'required|max:50|unique:users,email,'.Auth::user()->id,
            // もしemailを変更して、他の人とemailがかぶっていたら駄目だが、自分の既存のemailはダブりにカウントしない。
            'introduction' => 'max:100'
        ]);

        $user_a = $this->user->findOrFail(Auth::user()->id);
        $user_a->name = $request->name;
        $user_a->email = $request->email;
        $user_a->introduction = $request->introduction;

        if($request->avatar){ //check if avator is submitted with form
            //check if there is a current avatar
            if($user_a->avatar){
                //delete the current avatar file
                $this->deleteAvatar($user_a->avatar);
            }
            //save new avatar
            $user_a->avatar = $this->saveAvatar($request);

        }

        $user_a->save();

        return redirect()->route('profile.show', Auth::user()->id);

    }

    private function deleteAvatar($file_name){
        $file_path = self::LOCAL_STORAGE_FOLDER.$file_name;

        if(Storage::disk('local')->exists($file_path)){
            Storage::disk('local')->delete($file_path);
        }
    }

    private function saveAvatar($request){
        $file_name = time().".".$request->avatar->extension();

        $request->avatar->storeAs(self::LOCAL_STORAGE_FOLDER,$file_name);

        return $file_name;
    }

    public function followers($id){
        $user_a = $this->user->findOrFail($id);

        return view('users.profiles.followers')->with('user',$user_a);
    }

    public function following($id){
        $user_a = $this->user->findOrFail($id);

        return view('users.profiles.following')->with('user',$user_a);
    }

    public function changePassword(Request $request){

        //check if old password is correct
        $user_a = $this->user->findOrFail(Auth::user()->id);

        if(!Hash::check($request->old_password, $user_a->password)){
            //ユーザが入力したpasswordとデータベースのpasswordが違う場合
            //error
            return redirect()->back()->with('old_password_error','Incorrect current password');
        }

        //check if old password is not equal to new password

        if($request->old_password ==$request->new_password){
            //error
            return redirect()->back()->with('same_password_error','New password cannot be the same as old password');
        }

        //password confirmation is correct
        $request->validate([
            'new_password' => 'required|min:8|string|confirmed'
            // when using "confirmed", second input must be [input_name]_confirmation

            //confirmedを入れることで、comfirmationエラーの時以下のメッセージが表示されるようになる
            //The new password confirmation does not match.
        ]);

        $user_a->password = Hash::make($request->new_password);
        $user_a->save();

        return redirect()->back()->with('success_message','Password changed!');
    }
}
