<?php

namespace App;

use App\Libraries\Ultilities;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

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

    public function favourtie(){
        return $this->belongsToMany(User::class, 'favourites', 'motelroom_id','id');
    }

    public function postMenu(){
        return $this->belongsTo(PostMenu::class, 'post_menu', 'id');
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

    public function updateMotelInformation($request){
        $data = [
            'title'=> $request->txttitle,
            'description'=> $request->txtdescription,
            'price'=> $request->txtprice,
            'area'=> $request->txtarea,
            'address'=> $request->txtaddress,
            'post_type'=> $request->post_type,
            'post_menu'=> $request->post_menu,
            'start_date' =>$request->txtstart_date,
            'end_date' =>$request->txtend_date,
            'disctrict_id'=> $request->iddistrict,
            'category_id'=> $request->idcategory,
            'phone'=> $request->txtphone,
        ];

        $latlngArr = [
            0=>$request->txtlat,
            1=>$request->txtlng,
        ];
        $data['latlng'] = json_encode($latlngArr);
        $data['utilities'] = json_encode($request->tienich);
        $data['images'] = json_encode($request->hinhanh);
        if ($request->has('status')){
             $data['status'] = 1;
        }
        else
        {
            $data['status'] = 0;
        }
        dd($data);
    }

    public function updateMotel($request)
    {
        $data = [
            'id'=> $request->motelroom_id,
            'end_date'=>$request->term,
            'post_type' => $request->post_type
        ];
        $this->put($data);
    }

    public function uploadFiles($request){
        $images = [];
        $data = [];
        foreach ($request->hinhanh as $row){
           $images[] = Ultilities::uploadFile($row);
        }
        $data['id'] = $request->id;
        $data['images'] = json_encode($images);
        return $this->put($data);
    }
}
