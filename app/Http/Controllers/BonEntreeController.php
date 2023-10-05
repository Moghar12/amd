<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\BonEntree;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class BonEntreeController extends Controller
{
    public function create()
    {
        // Récupérer les fournisseurs et produits pour les options du formulaire
        $fournisseurs = Fournisseur::all();
        $products = Product::all();

        return view('bon_entrees.create', compact('fournisseurs', 'products'));
    }

    public function store(Request $request)
    {
        // Valider les données du formulaire ici selon vos besoins

        // Créer une nouvelle instance de BonEntree
        $bonEntree = new BonEntree();
        $bonEntree->fournisseur_id = $request->input('fournisseur_id');
        $bonEntree->date = $request->input('date');
        $bonEntree->type_document = $request->input('type_document');
        $bonEntree->numero_facture = $request->input('numero_facture');
        $bonEntree->save();

        // Enregistrer les produits dans la base de données
        $produitIds = $request->input('produit_id');
        $quantites = $request->input('quantite');
        $prixUnitaires = $request->input('prix_unitaire');
        $remises = $request->input('remise');

        foreach ($produitIds as $key => $produitId) {
            $produit = Product::find($produitId);

            // Calculer le prix total avec la remise
            $prixTotal = ($prixUnitaires[$key] * $quantites[$key]) - ($prixUnitaires[$key] * $quantites[$key] * $remises[$key] / 100);

            // Ajouter le produit au bon d'entrée avec les informations supplémentaires
            $produit->bonEntrees()->attach($bonEntree, [
                'quantite' => $quantites[$key],
                'prix_unitaire' => $prixUnitaires[$key],
                'remise' => $remises[$key],
                'prix_total' => $prixTotal,
            ]);
        }
        // Importer les données de prix_total de la table bon_entree_product
        DB::table('bon_entrees')
        ->join(DB::raw('(SELECT bon_entree_id, SUM(prix_total) as total_prix_total FROM bon_entree_product GROUP BY bon_entree_id) as subquery'), 'bon_entrees.id', '=', 'subquery.bon_entree_id')
        ->update(['bon_entrees.prix_total' => DB::raw('subquery.total_prix_total')]);

        // Ajoutez les produits au stock
    $produitIds = $request->input('produit_id');
    $quantites = $request->input('quantite');

    foreach ($produitIds as $key => $produitId) {
        $stock = Stock::where('product_id', $produitId)->first();

        if ($stock) {
            $stock->increment('quantity', $quantites[$key]);
        } else {
            Stock::create([
                'product_id' => $produitId,
                'quantity' => $quantites[$key],
            ]);
        }
    }
        // Rediriger ou retourner une réponse appropriée
        return redirect()->route('bon_entrees.index')->with('success', 'Le bon d\'entrée a été ajouté avec succès.');

    }

    public function index()
{
    // Récupérer tous les bons d'entrée avec leurs fournisseurs et produits associés
    $bonEntrees = BonEntree::with('fournisseur', 'products')
        ->latest() // Tri par ordre décroissant d'ID
        ->get();

    return view('bon_entrees.index', compact('bonEntrees'));
}
public function show(BonEntree $bon_entree)
{
    // Retrieve the related fournisseur and products for the BonEntree entry
    $bon_entree->load('fournisseur', 'products');

    return view('bon_entrees.show', compact('bon_entree'));
}

    public function destroy(BonEntree $bon_entree)
{
    // Delete the related records in the bon_entree_product pivot table
    $bon_entree->products()->detach();

    // Delete the bon d'entrée record
    $bon_entree->delete();

    // Redirect or return an appropriate response
    return redirect()->route('bon_entrees.index')->with('success', 'Le bon d\'entrée a été supprimé avec succès.');
}

// ...

public function edit(BonEntree $bon_entree)
{
    // Récupérer les fournisseurs et produits pour les options du formulaire
    $fournisseurs = Fournisseur::all();
    $products = Product::all();

    return view('bon_entrees.edit', compact('bon_entree', 'fournisseurs', 'products'));
}

public function update(Request $request, BonEntree $bon_entree)
{
    // Valider les données du formulaire ici selon vos besoins
    $bon_entree->fournisseur_id = $request->input('fournisseur_id');
    $bon_entree->date = $request->input('date');
    $bon_entree->type_document = $request->input('type_document');
    $bon_entree->numero_facture = $request->input('numero_facture');
    $bon_entree->save();

    // Supprimer les anciennes relations entre bon d'entrée et produits
    $bon_entree->products()->detach();

    // Enregistrer les nouveaux produits dans la base de données
    $produitIds = $request->input('produit_id');
    $quantites = $request->input('quantite');
    $prixUnitaires = $request->input('prix_unitaire');
    $remises = $request->input('remise');
    $oldQuantites = $request->input('old_quantite'); // Nouvelle variable ajoutée

    foreach ($produitIds as $key => $produitId) {
        $produit = Product::find($produitId);

        // Calculer le prix total avec la remise
        $prixTotal = ($prixUnitaires[$key] * $quantites[$key]) - ($prixUnitaires[$key] * $quantites[$key] * $remises[$key] / 100);

        // Ajouter le produit au bon d'entrée avec les informations supplémentaires
        $produit->bonEntrees()->attach($bon_entree, [
            'quantite' => $quantites[$key],
            'prix_unitaire' => $prixUnitaires[$key],
            'remise' => $remises[$key],
            'prix_total' => $prixTotal,
        ]);

        // Mettez à jour le stock du produit
        $stock = Stock::where('product_id', $produitId)->first();

        if ($stock) {
            // Mettez à jour le stock en fonction de la différence entre la nouvelle quantité et l'ancienne quantité
            $difference = $quantites[$key] - $oldQuantites[$key];
            $stock->increment('quantity', $difference);
        } else {
            Stock::create([
                'product_id' => $produitId,
                'quantity' => $quantites[$key],
            ]);
        }
    }

    // Importer les données de prix_total de la table bon_entree_product
    DB::table('bon_entrees')
        ->join(DB::raw('(SELECT bon_entree_id, SUM(prix_total) as total_prix_total FROM bon_entree_product GROUP BY bon_entree_id) as subquery'), 'bon_entrees.id', '=', 'subquery.bon_entree_id')
        ->update(['bon_entrees.prix_total' => DB::raw('subquery.total_prix_total')]);

    // Rediriger ou retourner une réponse appropriée
    return redirect()->route('bon_entrees.index')->with('success', 'Le bon d\'entrée a été mis à jour avec succès.');
}


// ...

    
}
