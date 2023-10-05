@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Détails du bon de sortie</h1>

        <div class="mb-3">
            <label for="client_id" class="form-label">Client</label>
            <input type="text" class="form-control" id="client_id" name="client_id" value="{{ $bonSortie->client->nom }}" readonly>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $bonSortie->date }}" readonly>
        </div>

        <div class="mb-3">
            <label for="type_document" class="form-label">Type de document</label><br>
            <input type="text" class="form-control" value="{{ $bonSortie->type_document }}" readonly>
        </div>

        <div class="mb-3">
            <label for="numero_document" class="form-label">Numéro de facture/BL</label>
            <input type="text" class="form-control" id="numero_document" name="numero_document" value="{{ $bonSortie->numero_document }}" readonly>
        </div>
        <div class="mb-3">
            <label for="escpt" class="form-label">ESCPT</label>
            <input type="text" class="form-control" id="escpt" name="escpt" value="{{ $bonSortie->escpt }}" readonly>
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
                    @foreach ($bonSortie->products as $product)
                    <tr class="produit-item">
                        <td>
                            <input type="text" class="form-control" value="{{ $product->name }}" readonly>
                        </td>
                        <td>
                            <input type="number" class="form-control" value="{{ $product->pivot->quantite }}" readonly>
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control" value="{{ $product->pivot->prix_unitaire }}" readonly>
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control" value="{{ $product->pivot->remise }}" readonly>
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control" value="{{ ($product->pivot->prix_unitaire * $product->pivot->quantite) - (($product->pivot->prix_unitaire * $product->pivot->quantite) * ($product->pivot->remise / 100)) }}" readonly>
                        </td>
                    </tr>
                    @endforeach
                    {{-- <tr>
                        <td colspan="5">
                            <a href="{{ route('bon_sorties.edit', $bonSortie->id) }}" class="btn btn-primary">Modifier</a>
                        </td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
        
        <a href="{{ route('bon_sorties.index') }}" class="btn btn-secondary">Retour</a>
    </div>
@endsection
