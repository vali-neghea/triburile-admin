<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function test() {
        return ResponseHelper::responseJson(200,1,'Poti s-o indoi fara s-o inmoi?','');
    }
}
