@extends('layouts.app')

@section('content')
<style>
    /* ... (existing styles) ... */
</style>
<div class="container">
    <h1>Liste des bons de livraison</h1>
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

    <div class="mb-4">
        <div class="input-group">
            <input type="text" id="search_numero_document" name="search_numero_document" class="form-control" placeholder="Rechercher par numéro de document">
            <input type="text" id="search" name="search" class="form-control" placeholder="Rechercher par client">
            <input type="date" id="start_date" name="start_date" class="form-control" placeholder="Date de début">
            <input type="date" id="end_date" name="end_date" class="form-control" placeholder="Date de fin">
            <div class="input-group-append">
                <button class="btn btn-primary" id="searchButton">Rechercher</button>
                <button class="btn btn-secondary" id="resetButton">Réinitialiser</button>
            </div>
        </div>
    </div>
    <div class="mb-2">
        <a href="{{ route('bon_sorties.create') }}" class="btn btn-success">Ajouter bon de livraison</a>
    </div>

    <table class="table" id="be-table">
        <thead>
            <tr class="data-row">
                <th class="highlight-column">Numéro de facture/BL</th>
                <th class="highlight-column">Client</th>
                <th class="highlight-column">Date</th>
                <th class="highlight-column">Type de document</th>
                <th class="highlight-column">Modalité de paiement</th>
                <th class="highlight-column">Montant Total</th>
                <th class="highlight-column">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bonSorties as $bonSortie)
                <tr class="clickable-row" data-href="{{ route('bon_sorties.show', $bonSortie->id) }}">
                    <td>{{ $bonSortie->numero_document }}</td>
                    <td>{{ $bonSortie->client->nom }}</td>
                    <td>{{ $bonSortie->date }}</td>
                    <td>{{ $bonSortie->type_document }}</td>
                    <td>{{ $bonSortie->modalite_paiement }}</td>
                    <td>{{ number_format($bonSortie->prix_total, 2, ',', ' ') }} </td>
                    <td>
                        <a href="{{ route('bon_sorties.edit', $bonSortie->id) }}" class="btn btn-primary">Modifier</a>
                        <a href="{{ route('bon_sorties.download-pdf', $bonSortie->id) }}" class="btn btn-success">Télécharger</a>
                        <form action="{{ route('bon_sorties.destroy', $bonSortie->id) }}" method="POST" style="display: inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce bon de sortie ?')">
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("search");
        const searchNumeroDocument = document.getElementById("search_numero_document");
        const startDateInput = document.getElementById("start_date");
        const endDateInput = document.getElementById("end_date");
        const searchButton = document.getElementById("searchButton");
        const resetButton = document.getElementById("resetButton");
        const table = document.getElementById("be-table");
        const rows = table.getElementsByTagName("tr");

        function filterRows() {
            const searchTerm = searchInput.value.toLowerCase();
            const searchNumero = searchNumeroDocument.value.toLowerCase();
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const clientName = row.getElementsByTagName("td")[1].textContent.toLowerCase();
                const numeroDocument = row.getElementsByTagName("td")[0].textContent.toLowerCase();
                const rowDate = row.getElementsByTagName("td")[2].textContent;

                const isSearchMatch = clientName.includes(searchTerm);
                const isNumeroMatch = numeroDocument.includes(searchNumero);
                const isDateMatch = (!startDate || rowDate >= startDate) && (!endDate || rowDate <= endDate);

                if (isSearchMatch && isNumeroMatch && isDateMatch) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        }

        function resetFilters() {
            searchInput.value = "";
            searchNumeroDocument.value = "";
            startDateInput.value = "";
            endDateInput.value = "";

            for (let i = 1; i < rows.length; i++) {
                rows[i].style.display = "";
            }
        }

        searchButton.addEventListener("click", filterRows);
        searchInput.addEventListener("keyup", filterRows);
        searchNumeroDocument.addEventListener("keyup", filterRows);
        startDateInput.addEventListener("change", filterRows);
        endDateInput.addEventListener("change", filterRows);
        resetButton.addEventListener("click", resetFilters);
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.getElementById("be-table");
        const rows = table.getElementsByClassName("clickable-row");

        function highlightRow(event) {
            event.currentTarget.classList.add("highlight-row");
        }

        function removeHighlight(event) {
            event.currentTarget.classList.remove("highlight-row");
        }

        function redirectToShowPage(event) {
            const clickedRow = event.currentTarget;
            const url = clickedRow.getAttribute("data-href");
            window.location.href = url;
        }

        for (let i = 0; i < rows.length; i++) {
            rows[i].addEventListener("mouseenter", highlightRow);
            rows[i].addEventListener("mouseleave", removeHighlight);
            rows[i].addEventListener("click", redirectToShowPage);
        }
    });
</script>


@endsection
