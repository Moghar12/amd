@extends('layouts.app')

@section('content')
<!-- ... (existing code) ... -->

</style>
<div class="container">
    <h1>Liste des bons d'entrée</h1>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif


    <div class="mb-4">
        <div class="input-group">
            <input type="text" id="search" name="search" class="form-control" placeholder="Rechercher un bon d'entrée par fournisseur">
            <input type="date" id="start_date" name="start_date" class="form-control" placeholder="Date de début">
            <input type="date" id="end_date" name="end_date" class="form-control" placeholder="Date de fin">
            <div class="input-group-append">
                <button class="btn btn-primary" id="searchButton">Rechercher</button>
                <button class="btn btn-secondary" id="resetButton">Réinitialiser</button>
                
            </div>
        </div>
    </div>
    <div class="mb-2">
        <a href="{{ route('bon_entrees.create') }}" class="btn btn-success">Ajouter bon d'entrée</a>
    </div>

    <table class="table" id="be-table">
        <thead>
            <tr class="data-row">
                <th>ID</th>
                <th class="highlight-column">Fournisseur</th>
                <th class="highlight-column">Date</th>
                <th class="highlight-column">Type de document</th>
                <th class="highlight-column">Numéro de facture/BL</th>
                <th class="highlight-column">Montant Total TTC</th>
                <th class="highlight-column">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bonEntrees as $bonEntree)
                <tr class="clickable-row" data-href="{{ route('bon_entrees.show', $bonEntree->id) }}">
                    <td>{{ $bonEntree->id }}</td>
                    <td>{{ $bonEntree->fournisseur->nom }}</td>
                    <td>{{ $bonEntree->date }}</td>
                    <td>{{ $bonEntree->type_document }}</td>
                    <td>{{ $bonEntree->numero_facture }}</td>
                    <td>{{ number_format($bonEntree->products->sum(function ($product) {
                        return ($product->pivot->prix_unitaire * $product->pivot->quantite) - ($product->pivot->prix_unitaire * $product->pivot->quantite * $product->pivot->remise / 100);
                    }), 2, ',', ' ') }}</td>
                
                    <td>
                        <a href="{{ route('bon_entrees.edit', $bonEntree->id) }}" class="btn btn-primary">Modifier</a>
                        <form action="{{ route('bon_entrees.destroy', $bonEntree->id) }}" method="POST" style="display: inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bon d\'entrée ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- ... (existing code) ... -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = document.getElementById("be-table");
        const rows = table.getElementsByClassName("clickable-row");

        function filterRows() {
            // ... (existing code) ...
        }

        // ... (existing code) ...

        function addBonEntree() {
            // ... (existing code) ...
        }

        // Function to handle the click event on clickable rows
        function redirectToShowPage(event) {
            const clickedRow = event.currentTarget;
            const url = clickedRow.getAttribute("data-href");

            // Redirect to the show page with all the information grayed out
            window.location.href = url;
        }

        // Attach the click event listener to each clickable row
        for (let i = 0; i < rows.length; i++) {
            rows[i].addEventListener("click", redirectToShowPage);
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("search");
        const startDateInput = document.getElementById("start_date");
        const endDateInput = document.getElementById("end_date");
        const searchButton = document.getElementById("searchButton");
        // const deleteButton = document.getElementById("deleteButton");
        const resetButton = document.getElementById("resetButton");
        const addButton = document.getElementById("addButton");
        const table = document.getElementById("be-table");
        const rows = table.getElementsByTagName("tr");

        function filterRows() {
            const searchTerm = searchInput.value.toLowerCase();
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const clientName = row.getElementsByTagName("td")[1].textContent.toLowerCase();
                const rowDate = row.getElementsByTagName("td")[2].textContent;

                const isSearchMatch = clientName.includes(searchTerm);
                const isDateMatch = (!startDate || rowDate >= startDate) && (!endDate || rowDate <= endDate);

                if (isSearchMatch && isDateMatch) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        }

        // function deleteRows() {
        //     Add your delete functionality here
        // }

        function resetFilters() {
            searchInput.value = "";
            startDateInput.value = "";
            endDateInput.value = "";

            for (let i = 1; i < rows.length; i++) {
                rows[i].style.display = "";
            }
        }

        function addBonEntree() {
            // Add your code here to handle the action when the "Ajouter" button is clicked
            // For example, you could redirect to a new page for creating a new entry voucher
        }
        


        searchButton.addEventListener("click", filterRows);
        searchInput.addEventListener("keyup", filterRows);
        startDateInput.addEventListener("change", filterRows);
        endDateInput.addEventListener("change", filterRows);
        // deleteButton.addEventListener("click", deleteRows);
        resetButton.addEventListener("click", resetFilters);
        addButton.addEventListener("click", addBonEntree);
    });
</script>




<script>
    document.addEventListener("DOMContentLoaded", function () {
      const table = document.getElementById("be-table");
      const rows = table.getElementsByClassName("clickable-row");
  
      // Function to add the highlight class when a row is hovered
      function highlightRow(event) {
        event.currentTarget.classList.add("highlight-row");
      }
  
      // Function to remove the highlight class when the mouse leaves the row
      function removeHighlight(event) {
        event.currentTarget.classList.remove("highlight-row");
      }
  
      // Function to handle the click event on clickable rows
      function redirectToShowPage(event) {
        const clickedRow = event.currentTarget;
        const url = clickedRow.getAttribute("data-href");
  
        // Redirect to the show page with all the information grayed out
        window.location.href = url;
      }
  
      // Attach event listeners to each clickable row
      for (let i = 0; i < rows.length; i++) {
        rows[i].addEventListener("mouseenter", highlightRow);
        rows[i].addEventListener("mouseleave", removeHighlight);
        rows[i].addEventListener("click", redirectToShowPage);
      }
    });
  </script>
  
@endsection
