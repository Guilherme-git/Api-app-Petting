<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $auth = new Auth();
        return $auth;
    }

    public function create(Request $request)
    {
        $users = User::where('email','=',$request->email)->get();

        if($users->get(0) == null)
        {
            $user = new User();
            $user->name = $request->name;
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            if ($request->image != null) {
                $user->image = $request->file('image')->store('user-image');
            }
            $user->type = $request->type;
            $user->save();

            return response()->json(['message'=>"Create"]);

        } else {
           return response()->json(['message'=>"Email já cadastrado"]);
        }
    }

    public function editProfile(Request $request)
    {
        $user = User::find($this->__construct()->me()->getData()->id);
        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->email = $request->email;
        if($request->password != null) {
        $user->password = bcrypt($request->password);
        }
        $user->save();

        return response()->json(['message'=>"Editado com sucesso"]);
    }

    public function editImageProfile(Request $request)
    {
        $user = User::find($this->__construct()->me()->getData()->id);
        Storage::delete($user->image);

        $user->image = $request->file('image')->store('user-image');
        $user->save();

        return response()->json(['image'=>$user->image]);
    }

    public function listAll()
    {
        $users = User::all();
        return $users;
    }

    public function edit(Request $request)
    {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->type = $request->type;
        $user->save();

        return response()->json(['message'=>"Editado com sucesso"]);
    }
}
