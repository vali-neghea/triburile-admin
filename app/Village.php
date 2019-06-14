<?php


namespace App;


use Illuminate\Database\Eloquent\Model;

class Village extends Model
{

    protected $hidden = [
        'villageTroops'
    ];

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

    public function productions() {
        return $this->hasMany('App\VillageProduction');
    }

    public function constructions() {
        return $this->hasMany('App\VillageConstruction');
    }

    public function villageTroops() {
        return $this->hasMany('App\VillageTroops');
    }
}
