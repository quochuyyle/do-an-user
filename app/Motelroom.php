<?php

namespace App;

use App\Libraries\Ultilities;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Support\Facades\Auth;

class Motelroom extends Model
{

    protected $fillable = ['title', 'price', 'description', 'area', 'count_view', 'address', 'latlng', 'images', 'user_id', 'category_id', 'district_id', 'utilities', 'phone', 'approve', 'slug', 'start_date', 'end_date'];
    use Sluggable;
    use SluggableScopeHelpers;

    protected $table = "motelrooms";

    public function category()
    {
        return $this->belongsTo('App\Categories', 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function district()
    {
        return $this->belongsTo('App\District', 'district_id', 'id');
    }

    public function reports()
    {
        return $this->hasMany('App\Reports', 'id_motelroom', 'id');
    }

    public function term()
    {
        return $this->hasOne(Term::class, 'motelroom_id', 'id')->orderBy('id', 'DESC');
    }

    public function favourtie()
    {
        return $this->belongsToMany(User::class, 'favourites', 'motelroom_id', 'id');
    }

    public function postMenu()
    {
        return $this->belongsTo(PostMenu::class, 'post_menu', 'id');
    }

    public function postCategory()
    {
        return $this->belongsTo(PostCategory::class, 'post_type', 'id');
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function put($data)
    {
        return self::where('id', $data['id'])->update($data);
    }

    public function updateMotelInformation($request)
    {  date_default_timezone_set('Asia/Ho_Chi_Minh');
        $data = [
            'id' => $request->id,
            'title' => $request->txttitle,
            'description' => $request->txtdescription,
            'price' => $request->txtprice,
            'area' => $request->txtarea,
            'address' => $request->txtaddress,
            'post_menu' => $request->postMenu,
            'district_id' => $request->iddistrict,
            'category_id' => $request->idcategory,
            'phone' => $request->txtphone,
        ];




        $detailMotelroom = $this->with('postCategory')->where('id', $data['id'])->first();
        $latlngArr = [
            0 => $request->txtlat,
            1 => $request->txtlng,
        ];
        $data['latlng'] = json_encode($latlngArr);
        $data['utilities'] = json_encode($request->tienich);
        if ($request->has('hinhanh')) {
            $data['images'] = json_encode($request->hinhanh);
        }


        if ($request->has('txtstart_date')) {
            $data['start_date'] = $request->txtstart_date;
        }
        if ($request->has('txtend_date')) {
            $data['end_date'] = $request->txtend_date;
        }
        if ($request->has('postCategory')) {
            $data['post_type'] = $request->postCategory;
        }
        if ($request->has('status')) {
            $data['status'] = 1;
        } else {
            $datetime1 = new \DateTime();
            $datetime2 = new \DateTime($detailMotelroom->end_date);
            $interval = $datetime2->diff($datetime1);
            $daysLeft = $interval->days;
            ;
            if($daysLeft > 0){
                $returnFee = $daysLeft * $detailMotelroom->postCategory->price;
                $modelUser = new User();
                $modelUser->updateWallet(null, Auth::user()->id, null, $returnFee);
                $currentDateTime = date('d-m-Y');
                $data['start_date'] = $currentDateTime;
                $data['end_date'] = $currentDateTime;
//                dd($data);
            }
            $data['status'] = 0;
        }
        return $this->put($data);
    }

    public function updateMotel($request)
    {
        $data = [
            'id' => $request->motelroom_id,
            'end_date' => $request->term,
            'post_type' => $request->post_type
        ];
        $this->put($data);
    }


}
