<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 5/24/2019
 * Time: 1:05 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageBuildings extends Model
{
    protected $table = 'village_building';

    public function building() {
        return $this->hasOne('App\Models\Building','id','building_id');
    }

    public function village() {
        return $this->hasOne('App\Models\Village','id','village_id');
    }
}
