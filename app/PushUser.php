<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PushUser extends Model
{
    //
    protected $table="push_user";

    protected $fillable=['push_id','user_id','read','user_type'];

    public  static  function store($data){

        return PushUser::create($data);
    }
}
