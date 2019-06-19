<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function send(Request $request) {
        dump($request);
        die('On file '. __FILE__ . 'at line ' . __LINE__);
    }
}
