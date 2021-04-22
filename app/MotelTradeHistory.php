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

        $data = [
            'user_id' => $request->user_id,
            'motelroom_id' => $request->motelroom_id,
            'type' => $request->type,
            'price' => $request->fee,
            'commission' => $request->commission,
            'receiving' => $request->receiving,
            'owner_id' => $request->owner_id,
        ];


        $newMotelTradeHistory = $this->store($data);
        return $newMotelTradeHistory;
    }
}
