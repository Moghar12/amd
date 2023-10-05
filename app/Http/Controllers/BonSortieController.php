<?php

namespace App\Http\Controllers;
use PDF;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\BonSortie;
use App\Models\Product;
use App\Models\Client;
use App\Models\Stock;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;





class BonSortieController extends Controller
{
     public function create()
     {
         $clients = Client::all();
         $products = Product::all();
         return view('bon_sorties.create', compact('clients', 'products'));
     }
 
    
     public function store(Request $request)
{
    $request->validate([
        'client_id' => 'required',
        'date' => 'required|date',
        'escpt' => 'required', // Assurez-vous d'ajouter des règles de validation appropriées
        'type_document' => 'required',
        'modalite_paiement' => 'required',
        'produit_id.*' => 'required',
        'prix_unitaire.*' => 'required',
        'quantite.*' => 'required',
        'remise.*' => 'required',
    ]);

    DB::beginTransaction();

    try {
        $bonSortie = new BonSortie();
        $bonSortie->client_id = $request->input('client_id');
        $bonSortie->date = $request->input('date');
        $bonSortie->escpt = $request->input('escpt');
        $bonSortie->type_document = $request->input('type_document');
        $bonSortie->modalite_paiement = $request->input('modalite_paiement');

        $typeDocumentPrefix = $bonSortie->type_document === 'facture' ? 'FC' : 'BL';
        $numeroDocument = $typeDocumentPrefix . date('Y') . strval($bonSortie->id);
        $bonSortie->numero_document = $numeroDocument;

        $existingBonSortie = BonSortie::where('numero_document', $numeroDocument)->first();
        if ($existingBonSortie) {
            $uniqueIdentifier = 1;
            while (BonSortie::where('numero_document', $numeroDocument . $uniqueIdentifier)->exists()) {
                $uniqueIdentifier++;
            }
            $numeroDocument .= $uniqueIdentifier;
        }
        $bonSortie->numero_document = $numeroDocument;

        $tva = 20;
        $prixTotalHT = 0;
        foreach ($request->input('produit_id') as $key => $produitId) {
            $produit = Product::find($produitId);
            $prixTotalHT += ($request->input('prix_unitaire')[$key] * $request->input('quantite')[$key]);
        }
        $tvaAmount = $prixTotalHT * $tva / 100;
        $bonSortie->tva = $tvaAmount;
        $bonSortie->prix_total = $prixTotalHT + $tvaAmount;

        $bonSortie->save();

        $produitIds = $request->input('produit_id');
        $quantites = $request->input('quantite');
        $remises = $request->input('remise');

        foreach ($produitIds as $key => $produitId) {
            $produit = Product::find($produitId);

            $remiseEnPourcentage = $remises[$key] / 100;

            $prixTotal = ($request->input('prix_unitaire')[$key] * $quantites[$key]) * (1 - $remiseEnPourcentage);

            $produit->bonSorties()->attach($bonSortie, [
                'quantite' => $quantites[$key],
                'prix_unitaire' => $request->input('prix_unitaire')[$key],
                'remise' => $remises[$key],
                'prix_total' => $prixTotal,
            ]);
        }

        $totalPrixTotal = DB::table('bon_sortie_product')
            ->where('bon_sortie_id', $bonSortie->id)
            ->sum('prix_total');

        $bonSortie->prix_total = $totalPrixTotal ;
        $bonSortie->save();

        $produitIds = $request->input('produit_id');
        $quantites = $request->input('quantite');
        $errors = [];

        foreach ($produitIds as $key => $produitId) {
            $produit = Product::find($produitId);

            if (!$produit) {
                return redirect()->back()->with('error', 'Le produit sélectionné n\'existe pas.');
            }

            $stock = Stock::where('product_id', $produitId)->first();

            if ($stock) {
                if ($stock->quantity >= $quantites[$key]) {
                    $stock->decrement('quantity', $quantites[$key]);
                } else {
                    $errors[] = [
                        'produit' => $produit->name,
                        'quantite' => $stock->quantity,
                    ];
                }
            } else {
                Stock::create([
                    'product_id' => $produitId,
                    'quantity' => -$quantites[$key],
                ]);
            }
        }

        if (!empty($errors)) {
            $errorMessage = 'La quantité en stock est insuffisante pour les produits suivants :';
            foreach ($errors as $error) {
                $errorMessage .= " Produit : {$error['produit']}, Quantité : {$error['quantite']}";
            }
            return redirect()->back()->with('error', $errorMessage);
        }

        DB::commit();

        return redirect()->route('bon_sorties.index')->with('success', 'Le bon de sortie a été ajouté avec succès.');
    } catch (Exception $e) {
        DB::rollback();
        return redirect()->back()->with('error', 'Une erreur s\'est produite lors de l\'enregistrement : ' . $e->getMessage());
    }
}

    public function index()
    {
        $bonSorties = BonSortie::with('client', 'products')
            ->latest() 
            ->get();

        return view('bon_sorties.index', compact('bonSorties'));
    }

    public function downloadPDF($id)
    {
        $bonSortie = BonSortie::with('client', 'products')->findOrFail($id);
    
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
    
        $dompdf = new Dompdf($options);
        $html = view('bon_sorties.pdf', compact('bonSortie'))->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
    
        return $dompdf->stream('facture_' . $bonSortie->numero_document . '.pdf');
    }

    public function show($id)
{
    $bonSortie = BonSortie::with('client', 'products')->findOrFail($id);

    return view('bon_sorties.show', compact('bonSortie'));
}

public function edit($id)
{
    $bonSortie = BonSortie::findOrFail($id); // Assuming you have a model named BonSortie

    $clients = Client::all(); // Assuming you have a model named Client
    $products = Product::all(); // Assuming you have a model named Product

    return view('bon_sorties.edit', compact('bonSortie', 'clients', 'products'));
}

public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'client_id' => 'required',
        'date' => 'required',
        'type_document' => 'required',
        'modalite_paiement' => 'required',
        'produit_id.*' => 'required',
        'quantite.*' => 'required',
        'prix_unitaire.*' => 'required',
        'remise.*' => 'required',
        'total.*' => 'required',
        'prix_total' => 'required',
        'escpt' => 'required|in:0%,3%,5%',
    ]);

    $bonSortie = BonSortie::findOrFail($id);

    $bonSortie->client_id = $request->input('client_id');
    $bonSortie->date = $request->input('date');
    $bonSortie->type_document = $request->input('type_document');
    $bonSortie->modalite_paiement = $request->input('modalite_paiement');
    $bonSortie->escpt = $request->input('escpt');

    if ($bonSortie->type_document === 'Bon de livraison') {
        $typeDocumentPrefix = 'BL';
    } elseif ($bonSortie->type_document === 'facture') {
        $typeDocumentPrefix = 'FC';
    } else {
        return redirect()->back()->with('error', 'Type de document invalide');
    }

    $products = $request->input('produit_id');
    $quantities = $request->input('quantite');
    $prices = $request->input('prix_unitaire');
    $discounts = $request->input('remise');

    $bonSortie->products()->sync([]);
    for ($i = 0; $i < count($products); $i++) {
        $bonSortie->products()->attach($products[$i], [
            'quantite' => $quantities[$i],
            'prix_unitaire' => $prices[$i],
            'remise' => $discounts[$i]
        ]);
    }

    $bonSortie->prix_total = $request->input('prix_total');

    $numeroDocument = $typeDocumentPrefix . date('Y') . $bonSortie->id; 
    $bonSortie->numero_document = $numeroDocument;
    $bonSortie->save();

    $produits = $request->input('produit_id');
    $quantites = $request->input('quantite');

    foreach ($produits as $key => $produitId) {
        $stock = Stock::where('product_id', $produitId)->first();

        if ($stock) {
            $stock->increment('quantity', $quantites[$key]);
        } else {
            return redirect()->back()->with('error', 'Le produit sélectionné n\'a pas de stock.');
        }
    }

    return redirect()->route('bon_sorties.index')->with('success', 'Le bon de sortie a été mis à jour avec succès.');
}




public function destroy($id)
{
    $bonSortie = BonSortie::findOrFail($id);
    $bonSortie->delete();

    return redirect()->route('bon_sorties.index');
}



}

        