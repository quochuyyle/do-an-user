<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    //
    protected $fillable = ['motelroom_id', 'user_id', 'price' , 'start_date', 'end_date'];
    public function user(){
      return $this->belongsTo(User::class);
    }

    public function store($data){
        return self::create($data);
    }

    public function createNewTerm($request){
       $data = [
           'motelroom_id'=>$request->motelroom_id,
           'user_id'=>$request->user_id,
           'price'=>$request->fee,
           'start_date'=>$request->start_date,
           'end_date'=>$request->term,
       ];

       $newTerm = $this->store($data);
       return $newTerm;
    }
}
