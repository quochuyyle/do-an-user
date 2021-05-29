<?php

namespace App;

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

    public function updateMotel($request)
    {
        $data = [
            'id'=> $request->motelroom_id,
            'end_date'=>$request->term,
            'post_type' => $request->post_type
        ];
        $this->put($data);
    }
}
