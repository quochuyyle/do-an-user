<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MotelTradeHistory extends Model
{
    //
    protected $table = 'motel_trade_histories';
    protected $fillable = ['user_id', 'motelroom_id', 'type', 'price' ,'commission', 'receiving', 'owner_id'];

    public function store($data){

        return self::create($data);
    }

    public function createMotelTradeHistory($request){

        $modelUser = new User();
        $data = [
            'user_id' => $request->user_id,
            'motelroom_id' => $request->motelroom_id,
            'type' => $request->type,
            'price' => $request->fee,
            'commission' => $request->commission,
            'receiving' => $request->receiving,
            'owner_id' => $request->owner_id,
        ];

        $owner = $modelUser->findOrFail($data['owner_id']);
        $user = $modelUser->findOrFail($data['user_id']);
        $admin =$modelUser->findOrFail(2);
        $modelUser->updateWalletMotelroomDetail($request, $user->id, $user->user_type);
        $modelUser->updateWalletMotelroomDetail($request, $owner->id, $owner->user_type);
        $modelUser->updateWalletMotelroomDetail($request, $admin->id, $admin->user_type);
        $newMotelTradeHistory = $this->store($data);
        return $newMotelTradeHistory;
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function motelroom(){
        return $this->belongsTo(Motelroom::class, 'motelroom_id', 'id');
    }
}
