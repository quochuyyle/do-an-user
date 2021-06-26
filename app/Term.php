<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
           'motelroom_id'=>$request->motelroom_id ? $request->motelroom_id : $request->id,
           'user_id'=>$request->user_id ? $request->user_id : Auth::user()->id,
           'price'=>$request->fee ? $request->fee : $request->txtfee,
           'start_date'=>$request->start_date ? $request->start_date : $request->txtstart_date,
           'end_date'=>$request->end_date ? $request->end_date : $request->txtend_date,
       ];

       $newTerm = $this->store($data);
       return $newTerm;
    }
}
