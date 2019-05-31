<?php
/**
 * Created by PhpStorm.
 * User: Andy
 * Date: 5/28/2019
 * Time: 2:47 PM
 */

namespace App\Http\Controllers;


use App\Continent;
use Illuminate\Http\Request;

class ContinentController extends Controller
{
    public function store(Request $request) {
        $continent = new Continent();

        $continent->name = $request->name;
        $continent->max_villages = $request->villages;
        $continent->villages = 0;

        $continent->save();

        $response = array(
            'success' => 1,
            'message' => 'continent created with success',
            'continent' => $continent
        );

        return response()->json($response);
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

        $response = array(
            'success' => 1,
            'continents' => $continents
        );

        return response()->json($response);
    }
}