@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Détails du bon d'entrée</h1>

        <div class="mb-3">
            <label for="fournisseur_id" class="form-label">Fournisseur</label>
            <input type="text" class="form-control" id="fournisseur_id" name="fournisseur_id" value="{{ $bon_entree->fournisseur->nom }}" readonly>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $bon_entree->date }}" readonly>
        </div>

        <div class="mb-3">
            <label for="type_document" class="form-label">Type de document</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type_document" id="facture" value="facture" {{ $bon_entree->type_document === 'facture' ? 'checked' : '' }} readonly>
                <label class="form-check-label" for="facture">Facture</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="type_document" id="Bon de livraison" value="Bon de livraison" {{ $bon_entree->type_document === 'Bon de livraison' ? 'checked' : '' }} readonly>
                <label class="form-check-label" for="Bon de livraison">Bon de livraison</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="numero_facture" class="form-label">Numéro de facture/BL</label>
            <input type="text" class="form-control" id="numero_facture" name="numero_facture" value="{{ $bon_entree->numero_facture }}" readonly>
        </div>

        <br>

        <div id="produits-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Quantité</th>
                        <th>Prix unitaire TTC</th>
                        <th>Remise %</th>
                        <th>Prix total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bon_entree->products as $product)
                    <tr class="produit-item">
                        <td>
                            <input type="text" class="form-control" value="{{ $product->name }}" readonly>
                        </td>
                        <td>
                            <input type="number" class="form-control" value="{{ number_format($product->pivot->quantite, 0, ',', ' ') }}" readonly>
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control" value="{{ number_format($product->pivot->prix_unitaire, 0, ',', ' ') }}" readonly>
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control" value="{{ number_format($product->pivot->remise, 0, ',', ' ') }}" readonly>
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control" value="{{ ($product->pivot->prix_unitaire * $product->pivot->quantite) - (($product->pivot->prix_unitaire * $product->pivot->quantite) * ($product->pivot->remise / 100)) }}" readonly>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <a href="{{ route('bon_entrees.index') }}" class="btn btn-secondary">Retour</a>
    </div>
@endsection
