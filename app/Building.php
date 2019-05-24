<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 5/24/2019
 * Time: 1:05 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    public function users() {
        return $this->belongsToMany('App\User');
    }
}