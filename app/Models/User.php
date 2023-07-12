<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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

    public function friendsRequest(){
        return $this->belongsToMany(User::class,'user_friends','sender_id','receiver_id')->where('user_friends.status','=',0);
    }


    public function friendsData(){
        return $this->belongsToMany(User::class,'user_friends','receiver_id','sender_id')->where('user_friends.status','=',2);
    }

    public function friendsBis(){
        return $this->belongsToMany(User::class,'user_friends','sender_id','receiver_id')->where('user_friends.status','=',1);
    }

    public static function usersFriends(){
        $friendsData = auth()->user()->friendsData()->pluck('sender_id')->toArray();
        $friendsBis = auth()->user()->friendsBis()->pluck('receiver_id')->toArray();

        $userId = array_unique(array_merge($friendsBis,$friendsData));
        return $userId;
    }

    // Create query for get use friends list
    public static function getAllUserFriendData($userId){
        $friendList = User::whereIn('id',$userId)->orderBy('created_at','DESC')->get();
        return $friendList;    
    }

    public static function userFriendsRequestList(){
        $friendsData = auth()->user()->friendsRequest()->pluck('receiver_id')->toArray();
        $userIds = array_unique($friendsData);
        return $userIds;
    }

}
