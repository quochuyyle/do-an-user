<?php

namespace App\Http\Controllers;

use App\Motelroom;
use App\Term;
use App\User;
use Illuminate\Http\Request;

class TermController extends Controller
{
    //
    public function extendTerm(Request  $request,Term $term, User $user,Motelroom  $modelMotelroom){
        $validate = [
            'motelroom_id'=>'required|numeric',
            'user_id'=>'required|numeric',
            'start_date'=>'required',
            'end_date'=>'required',
            'fee'=>'required|numeric'
        ];
        $request->validate($validate);


//        dd($request->all());

        $user->updateWallet($request);
        $modelMotelroom->updateMotel($request);
        $newTerm = $term->createNewTerm($request);

        if($newTerm){
            return response()->json([
                'message'=>'Gia hạn thành công !'
            ]);
        }
        else
        {
            return response()->json([
                'error'=>'Đã xảy ra lỗi.Xin thử lại !'
            ]);
        }
    }

}
