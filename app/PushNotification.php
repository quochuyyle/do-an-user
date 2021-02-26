<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    //

    protected $table='push_notification';

    protected $fillable=['name','content','sender_id','status','type','source','source_to','json_push'];

    public  static  function  store($data){
        return PushNotification::create($data);
    }
}
