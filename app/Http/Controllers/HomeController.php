<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\userFriends;
use Exception;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id = auth()->user()->id;
        $usersFriendID = User::usersFriends();
        $userFriends = User::getAllUserFriendData($usersFriendID);
        

        $friendsRequest = user::with('friendsRequest')->where('id',$id)->get();
        
        $users = User::whereNotIn('id',[$id])->get();
        return view('home',compact('userFriends','friendsRequest','users'));
    }


    public function AddFriendRequest(Request $request)
    {
        try{
                $friend = new userFriends();
                $friend->sender_id = auth()->user()->id;
                $friend->receiver_id = $request->receiver_id;
                $friend->save();
            
            return response()->json(['message' => 'send friend request successfully','status' => 200]);

        }catch(Exception $e){
            $message = $e->getMessage();
            return response()->json(['message' => $message,'status' => 500]);
        }
    }


    public function approvedRequest(Request $request,$id){
        try{
            $friend = userFriends::find($id);
            if(empty($friend)){
                return redirect('home');
            }
            $friend->status = 1;
            $friend->update();
            return redirect('home');
        }catch(Exception $e){
            return redirect('home');
        }
    }

    public function deleteFriends($id){
        try{
            $friend = userFriends::find($id);
            if(empty($friend)){
                return redirect('home');
            }
            $friend->status = 2;
            $friend->update();
            return redirect('home');
        }catch(Exception $e){
            return redirect('home');
        }
    }

}
