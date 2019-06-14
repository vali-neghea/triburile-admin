<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 5/24/2019
 * Time: 1:05 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Troop extends Model
{

    public function levels() {
        return $this->hasMany('App\TroopLevels');
    }

    public function villages() {
        return $this->hasMany('App\VillageTroops');
    }
}
