<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\CategoryClient;


class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->get();

        return view('clients.index', compact('clients'));
    }

 

public function create()
{
    $categories = CategoryClient::all();
    return view('clients.create', compact('categories'));
}




public function store(Request $request)
{
    $request->validate([
        'nom' => 'required',
        'ville' => 'required',
        'adresse' => 'required',
        'ICE' => 'required|unique:clients',
        'telephone' => 'required|digits:10|max:10',
        'category_id' => 'required|exists:category_clients,id',
    ]);
    

    $client = new Client();
    $client->nom = $request->input('nom');
    $client->ville = $request->input('ville');
    $client->adresse = $request->input('adresse');
    $client->telephone = $request->input('telephone');
    $client->category_client_id = $request->input('category_id');
    $client->ICE = $request->input('ICE');
    $client->save();

    $categoryID = $request->input('category_id');
    $clientCodeSuffix = '';

    switch ($categoryID) {
        case 1:
            $clientCodeSuffix = 'PHA';
            break;
        case 2:
            $clientCodeSuffix = 'GRO';
            break;
        case 3:
            $clientCodeSuffix = 'PARA';
            break;
        default:
            // Valeur par défaut si category_id ne correspond à aucun cas
            $clientCodeSuffix = 'DEFAULT';
            break;
    }

    $clientCode = $clientCodeSuffix . $client->id; // Modification de l'ordre du suffixe et de l'ID
    $client->client_code = $clientCode;
    $client->save();

    return redirect()->route('clients.index')->with('success', 'Client créé avec succès.');
}












public function edit($id)
{
    $client = Client::find($id);
    $categories = CategoryClient::all(); // Récupérer toutes les catégories

    return view('clients.edit', compact('client', 'categories'));
}

public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'nom' => 'required',
        'ville' => 'required',
        'adresse' => 'required',
        'ICE' => 'required|unique:clients,ICE,' . $id,
        'telephone' => 'required|digits:10|max:10',
    ]);

    $client = Client::find($id);
    $client->fill($validatedData);
    $client->save();

    return redirect()->route('clients.index')->with('success', 'Le client a été modifié avec succès.');
}



    public function destroy($id)
    {
        $client = Client::find($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Le client a été supprimé avec succès.');
    }
}
