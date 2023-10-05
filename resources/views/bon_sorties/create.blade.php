@extends('layouts.app')
@section('content')
    <div class="container">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
    
        @if (session('error')) 
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <h1>Ajouter un bon de livraison</h1>

        <form action="{{ route('bon_sorties.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="client_id" class="form-label">Client</label>
                <select name="client_id" id="client_id" class="form-control" required>
                    <option value="">Sélectionnez un client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->nom }}</option>
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
                <label for="modalite_paiement" class="form-label">Modalité de paiement</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="modalite_paiement" id="cheque" value="cheque" required>
                    <label class="form-check-label" for="cheque">Chèque</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="modalite_paiement" id="especes" value="especes" required>
                    <label class="form-check-label" for="especes">Espèces</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="modalite_paiement" id="virement" value="virement" required>
                    <label class="form-check-label" for="virement">Virement</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="escpt" class="form-label">ESCPT</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="escpt" id="0%" value="0%" required>
                    <label class="form-check-label" for="0%">0%</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="escpt" id="3%" value="3%" required>
                    <label class="form-check-label" for="3%">3%</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="escpt" id="5%" value="5%" required>
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
                            <th>PPH TTC</th>
                            <th>Remise %</th>
                            <th>Total TTC</th>
                            <th>
                                <button type="button" id="ajouter-produit-btn" class="btn btn-success">
                                    <span class="gg-add-r" style="--ggs:1"></span>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="produit-item">
                             {{-- <td>
                                <select name="produit_id[]" class="form-control" required>
                                    <option value="">Sélectionnez un produit</option>
                                    @foreach ($products as $produit)
                                        <option value="{{ $produit->id }}">{{ $produit->name }}</option>
                                    @endforeach
                                </select>
                            </td> --}}
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
                                {{-- <input type="number" step="0.01" class="form-control prix_unitaire"  name="prix_unitaire[]" value="{{ $produit->pph_ttc }}" required>  --}}
                                <input type="text" step="0.01" class="form-control prix_unitaire" name="prix_unitaire[]" readonly required>

                            </td>
                            <td>
                                <input type="number" step="0.01" class="form-control remise" name="remise[]" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" class="form-control total" name="total[]" readonly>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger supprimer-produit-btn">
                                    <span class="gg-close-r" style="--ggs:1"></span> 
                                </button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Prix Total</strong></td>
                            <td>
                                <input type="number" step="0.01" class="form-control" id="prix_total" name="prix_total" readonly>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <button type="submit" class="btn btn-primary">Ajouter</button>
            <a href="{{ route('bon_sorties.index') }}" class="btn btn-secondary">Retour</a>
        </form>
    </div>
{{-- 
    <script>
        
        function calculateTotal() {
            var produitItems = document.querySelectorAll('.produit-item');

            produitItems.forEach(function(item) {
                var quantite = item.querySelector('.quantite').value;
                var prixUnitaire = item.querySelector('.prix_unitaire').value;
                var remise = item.querySelector('.remise').value;

                var total = (quantite * prixUnitaire) - remise;
                item.querySelector('.total').value = total;
            });
        }


        
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
                        <input type="number" class="form-control quantite" name="quantite[]" required>
                    </td>
                    <td>
                        <input type="number" step="0.01" class="form-control prix_unitaire" name="prix_unitaire[]" required>
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
        });

        var produitsContainer = document.getElementById('produits-container');

        produitsContainer.addEventListener('click', function(event) {
            if (event.target.classList.contains('supprimer-produit-btn')) {
                var produitRow = event.target.closest('tr');
                produitRow.remove();
                calculateTotal(); // Recalculer le total lorsque vous supprimez un produit
            }
        });

        produitsContainer.addEventListener('input', calculateTotal);

        // Calculer le total initial lors du chargement de la page
        calculateTotal();
    });
    </script> --}}

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
