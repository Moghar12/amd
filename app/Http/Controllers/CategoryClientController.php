<?php

namespace App\Http\Controllers;

use App\Models\CategoryClient;
use Illuminate\Http\Request;

class CategoryClientController extends Controller
{
    public function index()
    {
        // Récupérer toutes les instances de CategoryClient
        $categoryClients = CategoryClient::all();

        // Retourner la vue ou les données JSON
        return view('category_clients.index', compact('categoryClients'));
    }

    public function create()
    {
        // Retourner la vue pour créer une nouvelle instance de CategoryClient
        return view('category_clients.create');
    }

    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required',
            'category_code' => 'required',
        ]);

        // Créer une nouvelle instance de CategoryClient avec les données validées
        $categoryClient = CategoryClient::create($validatedData);

        // Rediriger vers la page de détails du CategoryClient créé
        return redirect()->route('category_clients.show', $categoryClient);
    }

    public function show(CategoryClient $categoryClient)
    {
        // Retourner la vue pour afficher les détails d'un CategoryClient
        return view('category_clients.show', compact('categoryClient'));
    }

    public function edit(CategoryClient $categoryClient)
    {
        // Retourner la vue pour éditer un CategoryClient existant
        return view('category_clients.edit', compact('categoryClient'));
    }

    public function update(Request $request, CategoryClient $categoryClient)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required',
            'category_code' => 'required',
        ]);

        // Mettre à jour les attributs du CategoryClient avec les données validées
        $categoryClient->update($validatedData);

        // Rediriger vers la page de détails du CategoryClient mis à jour
        return redirect()->route('category_clients.show', $categoryClient);
    }

    public function destroy(CategoryClient $categoryClient)
    {
        // Supprimer le CategoryClient
        $categoryClient->delete();

        // Rediriger vers la liste des CategoryClients
        return redirect()->route('category_clients.index');
    }
}
