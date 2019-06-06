<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 5/28/2019
 * Time: 2:47 PM
 */

namespace App\Http\Controllers;


use App\Continent;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;

class ContinentController extends Controller
{
    public function store(Request $request) {
        $continent = new Continent();

        $continent->name = $request->name;
        $continent->max_villages = $request->villages;
        $continent->villages = 0;

        $continent->save();

        return ResponseHelper::responseJson(200,1,'Continent created with success',$continent);
    }

    public function index() {
        $continentsRaw = Continent::all();
        $continents = array();

        foreach ($continentsRaw as $key => $continent) {
            $continents[$key]['id'] = $continent->id;
            $continents[$key]['name'] = $continent->name;

            foreach ($continent->users as $user) {
                $continents[$key]['users'][] = array(
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'x' => $user->x_coordinates,
                    'y' => $user->y_coordinates,
                );
            }
        }

        return ResponseHelper::responseJson(200,1,'List of continents',$continents);
    }
}
