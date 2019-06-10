<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function continent() {
        return $this->belongsTo('App\Continent');
    }

    public function buildings()
    {
        return $this->belongsToMany('App\Building','village_building')->withPivot('level');
    }

}
