<?php

namespace App;

use App\Models\Category;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Motelroom;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "users";

    protected $fillable=['name','provider','provider_id','password','email','username'];

    public  function motelroom(){
        return $this->hasMany(Motelroom::class,'user_id','id');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function put($data)
    {

        return User::where('id', $data['id'])->update($data);
    }

    public function updateWallet($request)
    {
        $user = self::where('id', $request->user_id)->first();
        if ($request->has('money')) {
            $wallet = (int)($user->wallet) + (int)($request->money);
        }
        if ($request->has('fee')) {
            $wallet = (int)($user->wallet) - (int)($request->fee);
        }
        if ($request->has('txtfee')) {
            $wallet = (int)($user->wallet) - (int)($request->txtfee);
        }

        $data = [
            'id' => $request->user_id,
            'wallet' => $wallet
        ];

        $this->put($data);

    }
}
