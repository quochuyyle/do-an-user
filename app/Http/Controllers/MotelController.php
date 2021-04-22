<?php

namespace App\Http\Controllers;
use App\Term;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Motelroom;
use App\Categories;
use App\Reports;
use App\MotelTradeHistory;

class MotelController extends Controller
{
	public function SearchMotelAjax(Request $request){
		$getmotel = Motelroom::where([
			['district_id',$request->id_district],
			['price','>=',$request->min_price],
			['price','<=',$request->max_price],
			['category_id','like', "%$request->id_category%"],
			['approve',1]])->get();

		$arr_result_search = array();
		foreach ($getmotel as $room) {
			$arrlatlng = json_decode($room->latlng,true);
			$arrImg = json_decode($room->images,true);
			$arr_result_search[] = ["id" =>$room->id,"lat"=> $arrlatlng[0],"lng"=> $arrlatlng[1],"title"=>$room->title,"address"=> $room->address,"image"=>$arrImg[0],"phone"=>$room->phone];
		}
		return json_encode($arr_result_search);
	}

	public function user_del_motel($id){
		if (!Auth::check()) {
			return redirect('user/login');
		}
		else 
		{
			$getmotel = Motelroom::find($id);
			if(Auth::id() != $getmotel->user_id )
				return redirect('user/profile')->with('thongbao','Bạn không có quyền xóa bài đăng không phải là của bạn!');
			else
			{
				$getmotel->delete();
				return redirect('user/profile')->with('thongbao','Đã xóa bài đăng của bạn');
			}
		}
	}

	public function getMotelByCategoryId($id){
		$getmotel = Motelroom::where([['category_id',$id],['approve',1]])->paginate(3);
		$Categories = Categories::all();
		return view('home.category',['listmotel'=>$getmotel,'categories'=>$Categories]);
	}

	public function getMotelById(Request $request, Motelroom $modelMotelroom, Term $modelTerm){
	    if($request->ajax()){
	        $motelroom = $modelMotelroom->with('term')->where('id', $request->id)->first();
	        $term = $motelroom->term;
	        $terms = $modelTerm->where('motelroom_id', $request->id)->get();

	        return response()->json([
	            'motelroom'=>$motelroom,
                'term'=>$term,
                'view'=> view('motelroom.viewData', compact('terms'))->render()
            ]);
        }
    }


	public function userReport($id,Request $request){
		$ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    $report = new Reports;
	    $report->ip_address = $ipaddress;
	    $report->id_motelroom = $id;
	    $report->status = $request->baocao;
	    $report->save();
	    $getmotel = Motelroom::find($id);
		return redirect('phongtro/'.$getmotel->slug)->with('thongbao','Cảm ơn bạn đã báo cáo, đội ngũ chúng tôi sẽ xem xét');
	}

	public function rentMotel(Request $request){

    }

    public function showMotelInformations(Request $request, Motelroom $modelMotelroom, User $user, MotelTradeHistory $motelTradeHistory){
	    if ($request->ajax()) {
	        if ($request->has('type')) {
	            if ($request->get('type') == 0) {
//                    $motelroom = $modelMotelroom->where('id', $request->motelroom_id)->first();
//                    return $motelroom;
                }
	            else{
	                $validate = [
	                    'user_id'=>'required|numeric',
                        'motelroom_id'=>'required|numeric',
                        'type'=>'required|numeric',
                        'fee'=>'required|numeric',
                        'owner_id'=>'required|numeric',
//                        'user_id'=>'required|numeric',
//                        'user_id'=>'required|numeric',
                    ];

	                $request->validate($validate);

	                $user->updateWallet($request);
                    $newMotelTradeHistory = $motelTradeHistory->createMotelTradeHistory($request);
                    if ($newMotelTradeHistory)
                    {
                        return response()->json([
                            'message'=>'Updated successfully'
                        ]);
                    }
                    else
                    {
                        return response()->json([
                            'error'=>'Something went wrong'
                        ]);
                    }
                }
            }
        }
    }
}
