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

    public function recruitments() {
        return $this->hasMany('App\VillageRecruitment');
    }

    public function troops() {
        return $this->hasMany('App\VillageTroops');
    }

    public function productions() {
        return $this->hasMany('App\VillageProduction');
    }

    public function constructions() {
        return $this->hasMany('App\VillageConstruction');
    }
}
