<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class VillageTroops extends Model
{
    protected $table = "troop_village";

    public function troop() {
        return $this->hasOne('App\Models\Troop','id','troop_id');
    }

    public function village() {
        return $this->hasOne('App\Models\Village','id','village_id');
    }
}
