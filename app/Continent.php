<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 5/28/2019
 * Time: 2:48 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
    public function users() {
        return $this->hasMany('App\User');
    }
}