<?php

namespace App\Http\Controllers;

use App\District;
use App\Events\SendNotification;
use App\Favourite;
use App\Libraries\Ultilities;
use App\PostCategory;
use App\PostMenu;
use App\Province;
use App\PushNotification;
use App\PushUser;
use App\Term;
use App\Ultility;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Motelroom;
use App\Categories;
use App\Reports;
use App\MotelTradeHistory;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;


class MotelController extends Controller
{
    public function index(Request $request)
    {
        $provinces = Province::all();
        $district = District::all();
        $categories = Categories::all();
        $hot_motelroom = Motelroom::where('approve', 1)->limit(6)->orderBy('count_view', 'desc')->get();
        $map_motelroom = Motelroom::where('approve', 1)->get();
        $motelrooms = Motelroom::where('approve', 1)->orderBy('post_type', 'ASC')->paginate(4);
        $postmenus = PostMenu::all();

        if($request->ajax()){
            return view('motelroom.paginationData', compact( 'motelrooms'));
        }
        return view('home.index', compact('district', 'provinces', 'categories', 'hot_motelroom', 'map_motelroom', 'motelrooms', 'postmenus'));
    }

    public function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $motelrooms = Motelroom::where('approve', 1)->orderBy('post_type', 'ASC')->paginate(4);
            return view('motelroom.paginationData', compact('motelrooms'))->render();
        }
    }

    public function favouriteMotel(Request $request)
    {
        if ($request->ajax()) {
            $request->validate(Favourite::validator());
            if (!$request->type) {
                $modelFavourite = new Favourite();

                $favourite = $modelFavourite->addToFavourite($request);
                if ($favourite) {
                    return response()->json([
                        'data' => $favourite,
                        'message' => 'Add to your favourites successfully'
                    ]);
                }
            } else {
                $modelFavourite = new Favourite();
                $favourite = $modelFavourite->removeFromFavourite($request);
                if ($favourite) {
                    return response()->json([
                        'data' => $favourite,
                        'message' => 'Remove from your favourites successfully'
                    ]);
                }
            }
        }
    }

    public function yourFavourtieMotels(Request $request)
    {
        $motelroom = new Motelroom();
        $user = User::with('favourite')->findOrFail($request->id);
        $ids = [];
        foreach ($user->favourite as $row) {
            $ids [] = $row->motelroom_id;
        }
        $motelrooms = $motelroom->whereIn('id', $ids)->paginate(4);
        $provinces = Province::all();
        $district = District::all();
        $categories = Categories::all();
        $hot_motelroom = Motelroom::where('approve', 1)->limit(6)->orderBy('count_view', 'desc')->get();
        $map_motelroom = Motelroom::whereIn('id', $ids)->get();
        return view('home.index', compact('district', 'provinces', 'categories', 'hot_motelroom', 'map_motelroom', 'motelrooms'));
    }

    public function motelroomByPostMenu(Request $request)
    {

        $postMenu = PostMenu::where('slug', $request->slug)->first();
        $provinces = Province::all();
        $district = District::all();
        $categories = Categories::all();
        $hot_motelroom = Motelroom::where('approve', 1)->limit(6)->orderBy('count_view', 'desc')->get();
        $map_motelroom = Motelroom::where([['approve', '=', 1], ['post_menu', '=', $postMenu->id]])->get();
        $motelrooms = Motelroom::where([['approve', '=', 1], ['post_menu', '=', $postMenu->id]])->orderBy('post_type', 'ASC')->paginate(4);
        $postmenus = PostMenu::all();
        if($request->ajax()){
            return view('motelroom.paginationData', compact( 'motelrooms'));
        }
        return view('home.index', compact('district', 'provinces', 'categories', 'hot_motelroom', 'map_motelroom', 'motelrooms', 'postmenus'));
    }

    public function motelroomByPrice(Request $request)
    {
        $provinces = Province::all();
        $district = District::all();
        $categories = Categories::all();
        $hot_motelroom = Motelroom::where('approve', 1)->limit(6)->orderBy('count_view', 'desc')->get();
        $map_motelroom = Motelroom::whereBetween('price', array(Input::get('min'), Input::get('max')))->get();
        $getMotelrooms = Motelroom::whereBetween('price', array(Input::get('min'), Input::get('max')))->orderBy('price', 'ASC')->paginate(4);
        $postmenus = PostMenu::all();
        $motelrooms = $getMotelrooms->appends(Input::except('page'));
        if($request->ajax()){
            return view('motelroom.paginationData', compact( 'motelrooms'));
        }
        return view('home.index', compact('district', 'provinces', 'categories', 'hot_motelroom', 'map_motelroom', 'motelrooms'));
    }

    public function SearchMotelAjax(Request $request)
    {
        $getmotel = Motelroom::where([
            ['district_id', $request->id_district],
            ['price', '>=', $request->min_price],
            ['price', '<=', $request->max_price],
            ['category_id', 'like', "%$request->id_category%"],
            ['approve', 1]])->get();

        $arr_result_search = array();
        foreach ($getmotel as $room) {
            $arrlatlng = json_decode($room->latlng, true);
            $arrImg = json_decode($room->images, true);
            $arr_result_search[] = ["id" => $room->id, "lat" => $arrlatlng[0], "lng" => $arrlatlng[1], "title" => $room->title, "address" => $room->address, "image" => $arrImg[0], "phone" => $room->phone];
        }


        return json_encode($arr_result_search);
    }

    public function get_dangtin()
    {
//        $notifications=PushNotification::where('source_to',Auth::id())->limit(5)->get();
////        return View::share('notifications',$notifications);
//   	    dd($notifications);
        if (Auth::user()->user_type == 2) {
            return redirect()->back();
        }
        $district = District::all();
        $categories = Categories::all();
        $postCategories = PostCategory::all();
        $postMenus = PostMenu::all();
        return view('home.dangtin', compact('district', 'categories', 'postCategories', 'postMenus'));
    }

    public function post_dangtin(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'txttitle' => 'required',
            'txtaddress' => 'required',
            'txtprice' => 'required',
            'txtarea' => 'required',
            'txtphone' => 'required',
            'txtdescription' => 'required',
//            'txtaddress' => 'required',
            'term' => 'required',
            'txtfee' => 'required'
        ],
            [
                'txttitle.required' => 'Nhập tiêu đề bài đăng',
                'txtaddress.required' => 'Nhập địa chỉ phòng trọ',
                'txtprice.required' => 'Nhập giá thuê phòng trọ',
                'txtarea.required' => 'Nhập diện tích phòng trọ',
                'txtphone.required' => 'Nhập SĐT chủ phòng trọ (cần liên hệ)',
                'txtdescription.required' => 'Nhập mô tả ngắn cho phòng trọ',
//                'txtaddress.required' => 'Nhập hoặc chọn địa chỉ phòng trọ trên bản đồ',
                'term.required' => 'Nhập thời gian đăng tin',
            ]);


        /* Check file */
        $json_img = "";
        if ($request->hasFile('hinhanh')) {
            $arr_images = array();
            $inputfile = $request->file('hinhanh');
            foreach ($inputfile as $filehinh) {
                $namefile = "phongtro-" . str_random(5) . "-" . $filehinh->getClientOriginalName();
                while (file_exists('uploads/images' . $namefile)) {
                    $namefile = "phongtro-" . str_random(5) . "-" . $filehinh->getClientOriginalName();
                }
                $arr_images[] = $namefile;
                $filehinh->move('uploads/images', $namefile);
            }
            $json_img = json_encode($arr_images, JSON_FORCE_OBJECT);
        } else {
            $arr_images[] = "no_img_room.png";
            $json_img = json_encode($arr_images, JSON_FORCE_OBJECT);
        }
        /* tiện ích*/
        $json_tienich = json_encode($request->tienich, JSON_FORCE_OBJECT);
        /* ----*/
        /* get LatLng google map */
        $arrlatlng = array();
        $arrlatlng[] = $request->txtlat;
        $arrlatlng[] = $request->txtlng;
        $json_latlng = json_encode($arrlatlng, JSON_FORCE_OBJECT);

        /* --- */
        /* New Phòng trọ */
        $motel = new Motelroom;
        $motel->title = $request->txttitle;
        $motel->description = $request->txtdescription;
        $motel->price = $request->txtprice;
        $motel->area = $request->txtarea;
        $motel->count_view = 0;
        $motel->address = $request->txtaddress;
        $motel->latlng = $json_latlng;
        $motel->utilities = $json_tienich;
        $motel->images = $json_img;
        $motel->user_id = Auth::user()->id;
        $motel->category_id = $request->idcategory;
        $motel->district_id = $request->iddistrict;
        $motel->phone = $request->txtphone;
        $motel->start_date = $request->txtstart_date;
        $motel->end_date = $request->txtend_date;
        $motel->approve = 1;
        $motel->slug = Str::slug($request->txttitle . '-' . uniqid(), '-');
        $motel->post_type = $request->postCategory;
        $motel->post_menu = $request->post_menu;
        $motel->status = 1;
//        dd($motel);
////        dd($motel);
        $motel->save();

        $user = new User();
        $user->updateWallet($request);

        $term = new Term();
        $term->user_id = Auth::user()->id;
        $term->price = $request->txtfee;
        $term->start_date = $request->txtstart_date;
        $term->end_date = $request->txtend_date;
        $term->motelroom_id = $motel->id;
        $term->save();


        $name = "Có thông báo mới từ người dùng " . Auth::user()->name;
        $content = "1 bài đăng mới bởi người dùng " . Auth::user()->name;
        $data_notification = [
            'sender_id' => Auth::id(),
            'source' => Auth::id(),
            'source_to' => 2,
            'name' => $name,
            'content' => $content,
            'type_id' => $motel->id,
            'type' => 1

        ];
        $push_notification = PushNotification::store($data_notification);
        $data_user = [
            'push_id' => $push_notification->id,
            'user_id' => Auth::id(),
            'read' => 0,
            'user_type' => Auth::user()->user_type
        ];
//         $motel=['motel_id'=>$motel->id];
//         $push_notification=array_merge($push_notification,$motel);
        $push_user = PushUser::store($data_user);
        \event(new SendNotification($push_user->push_id, $push_notification));

//          \event(new SendNotification(1,['sender_id'=>Auth::id(),'source_to'=>2,'name'=>'Hello','content'=>'Test','created_at'=>"2021-02-24 08:33:50"]));
        return redirect('/user/dangtin')->with('success', 'Đăng tin thành công.');

    }

    public function user_del_motel($id)
    {
        if (!Auth::check()) {
            return redirect('user/login');
        } else {
            $getmotel = Motelroom::find($id);
            if (Auth::id() != $getmotel->user_id)
                return redirect('user/profile')->with('thongbao', 'Bạn không có quyền xóa bài đăng không phải là của bạn!');
            else {
                $getmotel->delete();
                return redirect('user/profile')->with('thongbao', 'Đã xóa bài đăng của bạn');
            }
        }
    }

    public function getMotelByCategoryId($id)
    {
        $getmotel = Motelroom::where([['category_id', $id], ['approve', 1]])->paginate(3);
        $Categories = Categories::all();
        return view('home.category', ['listmotel' => $getmotel, 'categories' => $Categories]);
    }

    public function getExtendTerm(Request $request)
    {
        $modelMotelroom = new Motelroom();
        $motelroom = $modelMotelroom->with(['term'])->where('id', $request->id)->first();
        $postCategories = PostCategory::all();
//        dd($motelroom);
        return view('motelroom.term.index', compact('motelroom', 'postCategories'));
    }

    public function extendTerm(Request $request, Term $term, User $user, Motelroom $modelMotelroom)
    {
        $validate = [
            'motelroom_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            'fee' => 'required|numeric',
            'post_type' => 'required|numeric',
        ];
        $request->validate($validate);


        $user->updateWallet($request);
        $modelMotelroom->updateMotel($request);
        $newTerm = $term->createNewTerm($request);

        if ($newTerm) {
            return redirect()->route('user.profile')->with(['message' => 'Gia hạn thành công']);
        } else {
            return redirect()->route('user.profile')->with(['message' => 'Đã có lỗi xảy ra !']);
        }
    }


    public function show(Request $request, Ultility $modelUltilities)
    {
        $motelroom = Motelroom::with(['term', 'postMenu'])->where('slug', $request->slug)->first();
        $motelroom->count_view = $motelroom->count_view + 1;
        $motelroom->save();
        $categories = Categories::all();
        $ids = (array)json_decode($motelroom->utilities);

        $ultitlities = $modelUltilities->whereIn('id', $ids)->get();
        return view('motelroom.detail', compact('motelroom', 'ultitlities'));
    }


    public function userReport($id, Request $request)
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        $report = new Reports;
        $report->ip_address = $ipaddress;
        $report->id_motelroom = $id;
        $report->status = $request->baocao;
        $report->save();
        $getmotel = Motelroom::find($id);
        return redirect('phongtro/' . $getmotel->slug)->with('thongbao', 'Cảm ơn bạn đã báo cáo, đội ngũ chúng tôi sẽ xem xét');
    }

    public function rentMotel(Request $request)
    {

    }

    public function showMotelInformations(Request $request, Motelroom $modelMotelroom, User $user, MotelTradeHistory $motelTradeHistory)
    {
        if ($request->ajax()) {
            if ($request->has('type')) {
                if ($request->get('type') == 0) {
//                    $motelroom = $modelMotelroom->where('id', $request->motelroom_id)->first();
//                    return $motelroom;
                } else {
                    $validate = [
                        'user_id' => 'required|numeric',
                        'motelroom_id' => 'required|numeric',
                        'type' => 'required|numeric',
                        'fee' => 'required|numeric',
                        'owner_id' => 'required|numeric',
//                        'user_id'=>'required|numeric',
//                        'user_id'=>'required|numeric',
                    ];

                    $request->validate($validate);

//	                $user->updateWallet($request);
                    $newMotelTradeHistory = $motelTradeHistory->createMotelTradeHistory($request);
                    if ($newMotelTradeHistory) {
                        return response()->json([
                            'message' => 'Updated successfully'
                        ]);
                    } else {
                        return response()->json([
                            'error' => 'Something went wrong'
                        ]);
                    }
                }
            }
        }
    }

    public function uploadImages(Request $request, Motelroom $modelMotelroom){
//        dd($request->all());
        $modelMotelroom->uploadFiles($request->hinhanh);
    }
}
