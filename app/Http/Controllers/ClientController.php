<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $auth = new Auth();
        return $auth;
    }

    public function create(Request $request)
    {
        $client = new Client();
        $client->amount = $request->amount;
        $client->name = $request->name;
        $client->expire = $request->expire;
        if ($request->image != null) {
            $client->image = $request->file('image')->store('client-image');
        }
        $client->paid = $request->paid;
        $client->user = $this->__construct()->me()->getData()->id;
        $client->save();

        foreach ($request->animal as $ani) {
            $animal = new Animal();
            $animal->name = $ani['name'];
            $animal->age = $ani['age'];
            $animal->type = $ani['type'];
            $animal->details = $ani['details'];
            $animal->birth = $ani['birth'];
            $animal->image = $request->file($ani['image'])->store('animal-image');
            $animal->client = $client->id;
            $animal->save();
        }

        $returnCLient = Client::where('id','=',$client->id)
            ->with('animal')
            ->get();

        $arrayClients = array();

        foreach ($returnCLient as $c)
        {
            if ($c['paid'] == 1) {
                array_push($arrayClients, [
                    "id" => $c['id'],
                    "amount" => $c['amount'],
                    "name" => $c['name'],
                    "animal" => $c['animal'],
                    "expire" => $c['expire'],
                    "image" => $c['image'],
                    "paid" => true
                ]);
            } else {
                array_push($arrayClients, [
                    "id" => $c['id'],
                    "amount" => $c['amount'],
                    "name" => $c['name'],
                    "animal" => $c['animal'],
                    "expire" => $c['expire'],
                    "image" => $c['image'],
                    "paid" => false
                ]);
            }

        }

        return response()->json($arrayClients[0]);
    }

    public function listAll()
    {
        $clients = Client::with('animal')
            ->get();

        $arrayClients = array();

        foreach ($clients as $client)
        {
            if ($client['paid'] == 1) {
                array_push($arrayClients, [
                    "id" => $client['id'],
                    "amount" => $client['amount'],
                    "name" => $client['name'],
                    "animal" => $client['animal'],
                    "expire" => $client['expire'],
                    "image" => $client['image'],
                    "paid" => true
                ]);
            } else {
                array_push($arrayClients, [
                    "id" => $client['id'],
                    "amount" => $client['amount'],
                    "name" => $client['name'],
                    "animal" => $client['animal'],
                    "expire" => $client['expire'],
                    "image" => $client['image'],
                    "paid" => false
                ]);
            }

        }
        return $arrayClients;
    }

    public function list()
    {
        $clients = Client::where('user', '=', $this->__construct()->me()->getData()->id)
            ->with('animal')
            ->get();

        $arrayClients = array();

        foreach ($clients as $client)
        {
            if ($client['paid'] == 1) {
                array_push($arrayClients, [
                    "id" => $client['id'],
                    "amount" => $client['amount'],
                    "name" => $client['name'],
                    "animal" => $client['animal'],
                    "expire" => $client['expire'],
                    "image" => $client['image'],
                    "paid" => true
                ]);
            } else {
                array_push($arrayClients, [
                    "id" => $client['id'],
                    "amount" => $client['amount'],
                    "name" => $client['name'],
                    "animal" => $client['animal'],
                    "expire" => $client['expire'],
                    "image" => $client['image'],
                    "paid" => false
                ]);
            }

        }
        return $arrayClients;
    }

    public function editImageAnimal(Request $request)
    {
        $animal = Animal::find($request->id);
        torage::delete($animal->image);

        $animal->image = $request->file('image')->store('animal-image');
        $animal->save();

        return response()->json(['image'=>$animal->image]);
    }
}
