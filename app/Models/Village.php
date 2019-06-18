<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Village extends Model
{

    protected $hidden = [
        'villageTroops'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function continent() {
        return $this->belongsTo('App\Models\Continent');
    }

    public function buildings()
    {
        return $this->belongsToMany('App\Models\Building','village_building')->withPivot('level');
    }

    public function recruitments() {
        return $this->hasMany('App\Models\VillageRecruitment');
    }

    public function productions() {
        return $this->hasMany('App\Models\VillageProduction');
    }

    public function constructions() {
        return $this->hasMany('App\Models\VillageConstruction');
    }

    public function villageTroops() {
        return $this->hasMany('App\Models\VillageTroops');
    }

    public function villageBuildings() {
        return $this->hasMany('App\Models\VillageBuildings');
    }
}
