@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ajouter un bon d'entrée</h1>

        <form action="{{ route('bon_entrees.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="fournisseur_id" class="form-label">Fournisseur</label>
                <select name="fournisseur_id" id="fournisseur_id" class="form-control" required>
                    <option value="">Sélectionnez un fournisseur</option>
                    @foreach ($fournisseurs as $fournisseur)
                        <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <div class="mb-3">
                <label for="type_document" class="form-label">Type de document</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type_document" id="facture" value="facture" required>
                    <label class="form-check-label" for="facture">Facture</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type_document" id="Bon de livraison" value="Bon de livraison" required>
                    <label class="form-check-label" for="Bon de livraison">Bon de livraison</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="numero_facture" class="form-label">Numéro de facture/BL</label>
                <input type="text" class="form-control" id="numero_facture" name="numero_facture" required>
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
                            <th>            <button type="button" id="ajouter-produit-btn" class="btn btn-success">
                                <span class="gg-add-r" style="--ggs:1"></span>
                            </button></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="produit-item">
                            <td>
                                <select name="produit_id[]" class="form-control" required>
                                    <option value="">Sélectionnez un produit</option>
                                    @foreach ($products as $produit)
                                        <option value="{{ $produit->id }}">{{ $produit->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="quantite[]" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" class="form-control" name="prix_unitaire[]" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" class="form-control" name="remise[]" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger supprimer-produit-btn">
                                    <span class="gg-close-r" style="--ggs:1"></span> 
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn btn-primary">Ajouter</button>
            <a href="{{ route('bon_entrees.index') }}" class="btn btn-secondary">Retour</a>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ajouterProduitBtn = document.getElementById('ajouter-produit-btn');

            ajouterProduitBtn.addEventListener('click', function() {
                var produitsContainer = document.getElementById('produits-container');
                var produitTableBody = produitsContainer.querySelector('tbody');
                var produitRow = document.createElement('tr');
                produitRow.classList.add('produit-item');

                var produitFields = `
                    <td>
                        <select name="produit_id[]" class="form-control" required>
                            <option value="">Sélectionnez un produit</option>
                            @foreach ($products as $produit)
                                <option value="{{ $produit->id }}">{{ $produit->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control" name="quantite[]" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control" name="prix_unitaire[]" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control" name="remise[]" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger supprimer-produit-btn">
                            <span class="gg-close-r" style="--ggs:1"></span> 
                        </button>
                    </td>
                `;

                produitRow.innerHTML = produitFields;
                produitTableBody.appendChild(produitRow);
            });

            var produitsContainer = document.getElementById('produits-container');

            produitsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('supprimer-produit-btn')) {
                    var produitRow = event.target.closest('tr');
                    produitRow.remove();
                }
            });
        });
    </script>
@endsection
