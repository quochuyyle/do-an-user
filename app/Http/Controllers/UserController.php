<?php

namespace App\Http\Controllers;

use App\Events\SendNotification;
use App\MotelTradeHistory;
use App\Term;
use App\PushNotification;
use App\PushUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\District;
use App\Categories;
use App\Motelroom;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /* Register */
//    public function __construct()
//    {
//        if (!Auth::check()) {
//            return view('auth.login');
//        }
//        else if (Auth::check())
//        {
//            if(Auth::user()->user_type == 2){
//                return \redirect()->route('user.index');
//            }
//        }
//
//    }


    public function get_register()
    {
        $categories = Categories::all();
        return view('home.register', ['categories' => $categories]);
    }

    public function post_register(Request $req)
    {

        $req->validate([
            'txtuser' => 'required|unique:users,username',
            'txtmail' => 'required|email|unique:users,email',
            'txtpass' => 'required|min:6',
            'txt-repass' => 'required|same:txtpass',
            'txtname' => 'required'
        ], [
            'txtuser.required' => 'Vui lòng nhập tài khoản',
            'txtuser.unique' => 'Tài khoản đã tồn tại trên hệ thống',
            'txtmail.unique' => 'Email đã tồn tại trên hệ thống',
            'txtmail.required' => 'Vui lòng nhập Email',
            'txtpass.required' => 'Vui lòng nhập mật khẩu',
            'txtpass.min' => 'Mật khẩu phải lớn hơn 6 kí tự',
            'txt-repass.required' => 'Vui lòng nhập lại mật khẩu',
            'txt-repass.same' => 'Mật khẩu nhập lại không trùng khớp',
            'txtname.required' => 'Nhập tên hiển thị'
        ]);
//   		dd($req->all());
        $newuser = new User;
        $newuser->username = $req->txtuser;
        $newuser->name = $req->txtname;
        $newuser->password = bcrypt($req->txtpass);
        $newuser->email = $req->txtmail;
        $newuser->user_type = $req->txttype;
        $newuser->save();
        return redirect('/user/register')->with('success', 'Đăng kí thành công');
    }

    /* Login */
    public function get_login()
    {
        $categories = Categories::all();
        return view('home.login', ['categories' => $categories]);
    }

    public function post_login(Request $req)
    {
        $req->validate([
            'txtuser' => 'required',
            'txtpass' => 'required',

        ], [
            'txtuser.required' => 'Vui lòng nhập tài khoản',
            'txtpass.required' => 'Vui lòng nhập mật khẩu'

        ]);
//        $user=$req->only('txtuser','txtpass');
        if (Auth::attempt(['username' => $req->txtuser, 'password' => $req->txtpass])) {
            return redirect('/');
        } else
            return redirect('user/login')->with('warn', 'Tài khoản hoặc mật khẩu không đúng');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('user/login');
    }

    public function getprofile()
    {

        $mypost = Motelroom::where('user_id', Auth::user()->id)->get();
        $categories = Categories::all();
        if (Auth::check() && Auth::user()->user_type == 3) {
            $motelTradeHistories = MotelTradeHistory::with(['motelroom', 'user'])->where('owner_id', Auth::user()->id)->get();
        }
        if (Auth::check() && Auth::user()->user_type == 2) {
            $motelTradeHistories = MotelTradeHistory::with(['motelroom', 'user'])->where('user_id', Auth::user()->id)->get();
        }

        return view('home.profile', [
            'categories' => $categories,
            'mypost' => $mypost,
            'motelTradeHistories' => $motelTradeHistories
        ]);
    }

    public function dataTable(Request $request, Motelroom $motel)
    {
        if ($request->ajax()) {
            $data = $motel->where('user_id', Auth::user()->id);
            if (!empty($request->get('min')) && !empty($request->get('max'))) {
                $min = (int)($request->get('min'));
                $max = (int)($request->get('max'));
                $data = $data->whereBetween('price', [$min, $max]);

            }
            if (!empty($request->get('category'))) {
                $category_id = $request->category;
                $data = $data->where('category_id', $category_id);
            }
            return DataTables::of($data->get())
                ->addIndexColumn()
                ->filter(function ($instance) use ($request, $motel) {
                    if (!empty($request->get('search'))) {
                        $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                            if (Str::contains(Str::lower($row['title']), Str::lower($request->get('search')))) {
                                return true;
                            }
                            return false;
                        });
                    }
                })
                ->addColumn('action', function ($data) {
                    return view('elements.action', [
                        'approve' => '<i class="fas fa-eye" style="color: darkseagreen;font-size:15px;margin:0 5px 0 0;"></i>',
                        'unapprove' => '<i class="fas fa-eye-slash" style="color: darkseagreen;font-size:15px;margin:0 5px 0 0;"></i>',
                        'model' => $data,
                        'url_edit' => route('admin.motel.approve', ['id' => $data->id]),
                        'url_destroy' => route('admin.motel.destroy', ['id' => $data->id])
                    ]);
                })
                ->addColumn('title', function ($data) {
                    return '<a href="' . route('admin.motel.detail', $data->id) . '">' . $data->title . '</a>';

                })
                ->addColumn('approve', function ($data) {
                    $approve = $data->approve == 1 ? "Đã kiểm duyệt" : "Chờ kiểm duyệt";
                    return "<span>$approve</span>";

                })
                ->addColumn('category_id', function ($data) {
                    $category = json_decode($data->category, true);
                    $cat_name = $category['name'];
                    return "<span>$cat_name</span>";

                })
                ->addColumn('posted_by', function ($data) {
                    $user = \GuzzleHttp\json_decode($data->user);
                    return "<span>$user->name</span>";

                })
                ->rawColumns(['action', 'title', 'approve', 'category_id', 'posted_by'])
                ->make(true);
        }
    }

    public function getEditprofile()
    {
        $user = User::find(Auth::user()->id);
        $categories = Categories::all();
        return view('home.edit-profile', [
            'categories' => $categories,
            'user' => $user
        ]);
    }

    public function postEditprofile(Request $request)
    {
        $categories = Categories::all();
        $user = User::find(Auth::id());
        if ($request->hasFile('avtuser')) {
            $file = $request->file('avtuser');
            var_dump($file);
            $exten = $file->getClientOriginalExtension();
            if ($exten != 'jpg' && $exten != 'png' && $exten != 'jpeg' && $exten != 'JPG' && $exten != 'PNG' && $exten != 'JPEG')
                return redirect('user/profile/edit')->with('thongbao', 'Bạn chỉ được upload hình ảnh có định dạng JPG,JPEG hoặc PNG');
            $Hinh = 'avatar-' . $user->username . '-' . time() . '.' . $exten;
            while (file_exists('uploads/avatars/' . $Hinh)) {
                $Hinh = 'avatar-' . $user->username . '-' . time() . '.' . $exten;
            }
            if (file_exists('uploads/avatars/' . $user->avatar))
                unlink('uploads/avatars/' . $user->avatar);

            $file->move('uploads/avatars', $Hinh);
            $user->avatar = $Hinh;
        }
        $this->validate($request, [
            'txtname' => 'min:3|max:20'
        ], [
            'txtname.min' => 'Tên phải lớn hơn 3 và nhỏ hơn 20 kí tự',
            'txtname.max' => 'Tên phải lớn hơn 3 và nhỏ hơn 20 kí tự'
        ]);
        if (($request->txtpass != '') || ($request->retxtpass != '')) {
            $this->validate($request, [
                'txtpass' => 'min:3|max:32',
                'retxtpass' => 'same:txtpass',
            ], [
                'txtpass.min' => 'password phải lớn hơn 3 và nhỏ hơn 32 kí tự',
                'txtpass.max' => 'password phải lớn hơn 3 và nhỏ hơn 32 kí tự',
                'retxtpass.same' => 'Nhập lại mật khẩu không đúng',
                'retxtpass.required' => 'Vui lòng nhập lại mật khẩu',
            ]);
            $user->password = bcrypt($request->txtpass);
        }

        $user->name = $request->txtname;
        $user->save();
        return redirect('user/profile/edit')->with('thongbao', 'Cập nhật thông tin thành công');

        // return view('home.edit-profile',[
        //    'categories'=>$categories,
        //    'user'=> $user
        // ]);
    }

    /* Đăng tin */
    public function get_dangtin()
    {
//        $notifications=PushNotification::where('source_to',Auth::id())->limit(5)->get();
////        return View::share('notifications',$notifications);
//   	    dd($notifications);
        $district = District::all();
        $categories = Categories::all();
        return view('home.dangtin', [
            'district' => $district,
            'categories' => $categories
        ]);
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
            'txtaddress' => 'required',
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
                'txtaddress.required' => 'Nhập hoặc chọn địa chỉ phòng trọ trên bản đồ',
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
}
