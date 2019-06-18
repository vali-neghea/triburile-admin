<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 5/24/2019
 * Time: 1:05 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    public function villages() {
        return $this->hasMany('App\Models\VillageBuildings');
    }

    public function levels() {
        return $this->hasMany('App\Models\BuildingLevels');
    }
}
