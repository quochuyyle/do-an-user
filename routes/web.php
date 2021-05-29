<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\User;
use App\District;
use App\Categories;
use App\Motelroom;
use App\Province;
use Illuminate\Support\Facades\Auth;

Route::get('/', 'MotelController@index')->name('user.index');
Route::get('/pagination/fetch_data', 'MotelController@fetch_data')->name('user.motelroom.fetch_data');
Route::post('/favourite-motel', 'MotelController@favouriteMotel')->name('user.motel.favourite');
Route::get('/{id}/favourite-motel', 'MotelController@yourFavourtieMotels')->name('user.index.favourite');
Route::get('category/{id}','MotelController@getMotelByCategoryId');
/* Admin */
Route::get('admin/login','AdminController@getLogin');
Route::post('admin/login','AdminController@postLogin')->name('admin.login');
Route::group(['prefix'=>'admin','middleware'=>'adminmiddleware'], function () {
    Route::get('logout','AdminController@logout');
    Route::get('','AdminController@getIndex');
    Route::get('thongke','AdminController@getThongke');
    Route::get('report','AdminController@getReport');
    Route::group(['prefix'=>'users'],function(){
        Route::get('list','AdminController@getListUser');
        Route::get('edit/{id}','AdminController@getUpdateUser');
        Route::post('edit/{id}','AdminController@postUpdateUser')->name('admin.user.edit');
        Route::get('del/{id}','AdminController@DeleteUser');
    });
    Route::group(['prefix'=>'motelrooms'],function(){
        Route::get('list','AdminController@getListMotel');
        Route::get('approve/{id}','AdminController@ApproveMotelroom');
        Route::get('unapprove/{id}','AdminController@UnApproveMotelroom');
        Route::get('del/{id}','AdminController@DelMotelroom');
        // Route::get('edit/{id}','AdminController@getUpdateUser');
        // Route::post('edit/{id}','AdminController@postUpdateUser')->name('admin.user.edit');
        // Route::get('del/{id}','AdminController@DeleteUser');
    });
});
/* End Admin */
Route::get('/phongtro/{slug}',function($slug){
   // $room = Motelroom::findBySlug($slug)->with('term');
    $room = Motelroom::with('term')->where('slug', $slug)->first();
    $room->count_view = $room->count_view +1;
    $room->save();
    $categories = Categories::all();
    return view('home.detail',['motelroom'=>$room, 'categories'=>$categories]);
})->name('user.motelroom.detail');
Route::get('/report/{id}','MotelController@userReport')->name('user.report');
Route::get('/motelroom/show/{id}','MotelController@getMotelById')->name('user.motelroom.show');
Route::get('/motelroom/del/{id}','MotelController@user_del_motel');
Route::get('/term/{id}','MotelController@getExtendTerm')->name('user.motelroom.term');
Route::post('/term/{motelroom_id}/store','MotelController@extendTerm')->name('user.term.store');
/* User */
Route::group(['prefix'=>'user'], function () {
    Route::get('register','UserController@get_register');
    Route::post('register','UserController@post_register')->name('user.register');

    Route::get('login','UserController@get_login');
    Route::post('login','UserController@post_login')->name('user.login');
    Route::get('logout','UserController@logout');

    Route::get('dangtin','MotelController@get_dangtin')->middleware('dangtinmiddleware');
    Route::get('dangtin/datatable','UserController@dataTable')->name('user.dangtin.datatable');
    Route::post('dangtin','MotelController@post_dangtin')->name('user.dangtin')->middleware('dangtinmiddleware');
    Route::get('hienthi/{id}','UserController@hienThongTinNhaTro')->name('user.dangtin.hienthi')->middleware('dangtinmiddleware');
    Route::post('chinhsua/{id}','UserController@chinhSuaThongTinNhaTro')->name('user.dangtin.sua')->middleware('dangtinmiddleware');


    Route::get('profile','UserController@getprofile')->middleware('dangtinmiddleware')->name('user.profile');
    Route::get('profile/edit','UserController@getEditprofile')->middleware('dangtinmiddleware');
    Route::post('profile/edit','UserController@postEditprofile')->name('user.edit')->middleware('dangtinmiddleware');
});
/* ----*/

Route::get('/postcategory','PostCategoryController@index')->name('postcategory.index');
Route::get('/postmenu/{slug}','MotelController@motelroomByPostMenu')->name('postmenu.motelroom');
Route::get('/price','MotelController@motelroomByPrice')->name('price.motelroom');
Route::get('/payment','PageController@paymentMethod')->name('payment.index');
Route::post('searchmotel','MotelController@SearchMotelAjax');
Route::get('district/{id}','DistrictController@getList')->name('district.list');

Route::post('rentmotel','MotelController@rentMotel')->name('rent.create');
Route::post('showphonenumber','MotelController@showMotelInformations')->name('rent.phone.show');