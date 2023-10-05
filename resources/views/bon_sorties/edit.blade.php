@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Modifier le bon de sortie</h1>

        <form action="{{ route('bon_sorties.update', $bonSortie->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="client_id" class="form-label">Client</label>
                <select name="client_id" id="client_id" class="form-control" required>
                    <option value="">Sélectionnez un client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" {{ $bonSortie->client_id == $client->id ? 'selected' : '' }}>{{ $client->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Date</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ $bonSortie->date }}" required>
            </div>

            <div class="mb-3">
                <label for="type_document" class="form-label">Type de document</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type_document" id="facture" value="facture" {{ $bonSortie->type_document === 'facture' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="facture">Facture</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="type_document" id="Bon de livraison" value="Bon de livraison" {{ $bonSortie->type_document === 'Bon de livraison' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="Bon de livraison">Bon de livraison</label>
                </div>
            </div>

            <div class="mb-3">
                <label for="modalite_paiement" class="form-label">Modalité de paiement</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="modalite_paiement" id="cheque" value="cheque" {{ $bonSortie->modalite_paiement === 'cheque' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="cheque">Chèque</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="modalite_paiement" id="especes" value="especes" {{ $bonSortie->modalite_paiement === 'especes' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="especes">Espèces</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="modalite_paiement" id="virement" value="virement" {{ $bonSortie->modalite_paiement === 'virement' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="virement">Virement</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="escpt" class="form-label">ESCPT</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="escpt" id="0%" value="0%" {{ $bonSortie->escpt === '0%' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="0%">0%</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="escpt" id="3%" value="3%" {{ $bonSortie->escpt === '3%' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="3%">3%</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="escpt" id="5%" value="5%" {{ $bonSortie->escpt === '5%' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="5%">5%</label>
                </div>
            </div>
            <br>

            <div id="produits-container">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Remise %</th>
                            <th>Total</th>
                            <th>
                                <button type="button" id="ajouter-produit-btn" class="btn btn-success">
                                    <span class="gg-add-r" style="--ggs:1"></span>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bonSortie->products as $product)
                            <tr class="produit-item">
                                <td>
                                    <select name="produit_id[]" class="form-control" required>
                                        <option value="">Sélectionnez un produit</option>
                                        @foreach ($products as $produit)
                                            <option value="{{ $produit->id }}" {{ $product->id == $produit->id ? 'selected' : '' }}>{{ $produit->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" class="form-control quantite" name="quantite[]" value="{{ $product->pivot->quantite }}" required>
                                </td>
                                <td>
                                    <input type="text" step="0.01" class="form-control prix_unitaire" name="prix_unitaire[]" value="{{ $product->pivot->prix_unitaire }}"  required>
                                </td>
                                <td>
                                    <input type="number" step="0.01" class="form-control remise" name="remise[]" value="{{ $product->pivot->remise }}" required>
                                </td>
                                <td>
                                    <input type="text" step="0.01" class="form-control total" name="total[]" value="{{ ($product->pivot->prix_unitaire * $product->pivot->quantite) - (($product->pivot->prix_unitaire * $product->pivot->quantite) * ($product->pivot->remise / 100)) }}" readonly>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger supprimer-produit-btn">
                                        <span class="gg-close-r" style="--ggs:1"></span> 
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Prix Total</strong></td>
                            <td>
                                <input type="number" step="0.01" class="form-control" id="prix_total" name="prix_total" value="{{ $bonSortie->prix_total }}" readonly>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('bon_sorties.index') }}" class="btn btn-secondary">Retour</a>
        </form>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            function calculateTotal() {
                var produitItems = document.querySelectorAll('.produit-item');
                var total = 0;
        
                produitItems.forEach(function(item) {
                var quantite = item.querySelector('.quantite').value;
                var prixUnitaire = item.querySelector('.prix_unitaire').value;
                var remise = item.querySelector('.remise').value;
        
        // Convertir la remise en pourcentage en une valeur proportionnelle
                var remiseEnPourcentage = remise / 100;
        
                var subtotal = (quantite * prixUnitaire) * (1 - remiseEnPourcentage);
                item.querySelector('.total').value = subtotal.toFixed(2);
        
        
                    total += subtotal;
                });
        
                document.getElementById('prix_total').value = total.toFixed(2);
            }
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
                                <option value="{{ $produit->id }}" data-prix="{{ $produit->pph_ttc }}">{{ $produit->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control quantite" name="quantite[]" required>
                    </td>
                    <td>
                        <input type="text" step="0.01" class="form-control prix_unitaire" name="prix_unitaire[]" readonly required>
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control remise" name="remise[]" required>
                    </td>
                    <td>
                        <input type="text" step="0.01" class="form-control total" name="total[]" readonly>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger supprimer-produit-btn">
                            <span class="gg-close-r" style="--ggs:1"></span> 
                        </button>
                    </td>
                `;
        
                produitRow.innerHTML = produitFields;
                produitTableBody.appendChild(produitRow);
        
                // Mettez à jour les totaux lors de l'ajout d'un produit
                calculateTotal();
                
                // Intégration du script pour mettre à jour automatiquement les prix unitaires
                var selectElements = document.querySelectorAll('select[name="produit_id[]"]');
                var prixUnitaireInputs = document.querySelectorAll('.prix_unitaire');
        
                selectElements.forEach(function(selectElement, index) {
                    selectElement.addEventListener('change', function() {
                        var selectedProductId = this.value;
                        var prixUnitaireInput = prixUnitaireInputs[index];
                        var produitOptions = this.options;
        
                        for (var i = 0; i < produitOptions.length; i++) {
                            if (produitOptions[i].value == selectedProductId) {
                                var prix = produitOptions[i].getAttribute('data-prix');
                                prixUnitaireInput.value = prix;
                                break;
                            }
                        }
        
                        calculateTotal(); // Mettez à jour le total après le changement de produit
                    });
                });
            });
        
            var produitsContainer = document.getElementById('produits-container');
        
            produitsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('supprimer-produit-btn')) {
                    var produitRow = event.target.closest('tr');
                    produitRow.remove();
                    calculateTotal();
                }
            });
        
            produitsContainer.addEventListener('input', calculateTotal);
        
            calculateTotal(); // Calculer le total initial lors du chargement de la page
           
        });
        
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var selectElements = document.querySelectorAll('select[name="produit_id[]"]');
                var prixUnitaireInputs = document.querySelectorAll('.prix_unitaire');
        
                selectElements.forEach(function(selectElement, index) {
                    selectElement.addEventListener('change', function() {
                        var selectedProductId = this.value;
                        var prixUnitaireInput = prixUnitaireInputs[index];
                        var produitOptions = this.options;
        
                        for (var i = 0; i < produitOptions.length; i++) {
                            if (produitOptions[i].value == selectedProductId) {
                                var prix = produitOptions[i].getAttribute('data-prix');
                                prixUnitaireInput.value = prix;
                                break;
                            }
                        }
                    });
                });
            });
        </script>
       
@endsection
