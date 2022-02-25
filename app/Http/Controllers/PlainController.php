<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlainController extends Controller
{
    public function create(Request $request)
    {
        $plain = new Plan();
        $plain->name = $request->name;
        $plain->price = $request->price;
        $plain->time = $request->time;
        $plain->save();

        return response()->json(['message'=>"Salvo com sucesso"]);
    }

    public function list()
    {
        $plains = Plan::all();
        return $plains;
    }

    public function editValue(Request $request)
    {
        $plain = Plan::find($request->id);
        $plain->price = $request->price;
        $plain->save();

        return response()->json(['message'=>"Editado com sucesso"]);
    }
}
