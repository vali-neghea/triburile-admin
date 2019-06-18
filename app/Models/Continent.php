<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 5/28/2019
 * Time: 2:48 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
    public function villages() {
        return $this->hasMany('App\Village');
    }
}
