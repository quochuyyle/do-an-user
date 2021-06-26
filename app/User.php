<?php

namespace App;

use App\Models\Category;
use App\Motelroom;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


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

    public  function tradeHistory(){
        return $this->hasMany(MotelTradeHistory::class,'user_id','id');
    }

    public  function specificTradeHistory($motelroom_id){

        return $this->with('tradeHistory')->whereHas('tradeHistory', function ($q) use ($motelroom_id) {
            $q->where('motelroom_id', $motelroom_id);
        })->first();
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

    public function updateWallet($request = null, $user_id = null, $user_type = null, $returnFee = null)
    {
        $user_id = $user_id ? $user_id : $request->user_id;
        $user = self::where('id', $user_id)->first();
        $wallet = 0;
        if (!empty($request)) {
            if ($request->has('money')) {
                $wallet = (int)($user->wallet) + (int)($request->money);
            }
            if ($request->has('fee')) {
                $wallet = (int)($user->wallet) - (int)($request->fee);
            }
            if ($request->has('txtfee')) {
                $wallet = (int)($user->wallet) - (int)($request->txtfee);
            }

        }
        if (!empty($returnFee)) {
            $wallet = (int)($user->wallet) + (int)($returnFee);
        }



        if($wallet > 0) {
            $data = [
                'id' => isset($request) ? $request->user_id : $user_id,
                'wallet' => $wallet
            ];
            return $this->put($data);
        }
        else
        {
            return redirect()->back()->with(['message'=>'Tài khoản của bạn không đủ tiền để thực hiện']);
        }



    }


    public function updateWalletMotelroomDetail($request, $user_id = null, $user_type = null)
    {
        $user_id = $user_id ? $user_id : $request->user_id;
        $user = self::where('id', $user_id)->first();
        $wallet = 0;
        //Người dùng
        if ($user_type == 2 && $request->has('fee'))  {
            $wallet = (int)($user->wallet) - (int)($request->fee);
        }
        //Chủ nhà trọ
        if ($user_type == 3 && $request->has('commission'))  {
            $wallet = (int)($user->wallet) + (int)($request->commission);
        }

        if ($user_type == 1 && $request->has('receiving'))  {
            $wallet = (int)($user->wallet) + (int)($request->receiving);
        }
        $data = [
            'id' => $user->id,
            'wallet' => $wallet
        ];

        $this->put($data);

    }

    public function favourite(){
        return $this->hasMany(Favourite::class, 'user_id', 'id');
    }
}
