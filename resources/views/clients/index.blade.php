@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des clients</h1>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="search-bar">
        <div class="input-group mb-4">
           
            <input type="text" id="search" name="search" class="form-control" placeholder="Rechercher un client">
            <select id="cityFilter" class="form-control">
                <option value="">Toutes les villes</option>
                <option value="Agadir">Agadir</option>
                <option value="Casablanca">Casablanca</option>
                <option value="El Jadida">El Jadida</option>
                <option value="Fès">Fès</option>
                <option value="Kenitra">Kenitra</option>
                <option value="Marrakech">Marrakech</option>
                <option value="Meknès">Meknès</option>
                <option value="Mohammedia">Mohammedia</option>
                <option value="Nador">Nador</option>
                <option value="Oujda">Oujda</option>
                <option value="Rabat">Rabat</option>
                <option value="Salé">Salé</option>
                <option value="Tanger">Tanger</option>
                <option value="Témara">Témara</option>
                <option value="Tétouan">Tétouan</option>
            </select>
            
            <div class="input-group-append">
                <button id="resetBtn" class="btn btn-outline-secondary" type="button">Réinitialiser</button>
            </div>
        </div>
    </div>

    <div class="mb-2">
        <a href="{{ route('clients.create') }}" class="btn btn-success">Ajouter client</a>
    </div>

    <table class="table" id="client-table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Téléphone</th>
                <th>Ville</th>
                <th>Adresse</th>
                <th>ICE</th>
                <th>Actions</th> 
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr data-city="{{ $client->ville }}">
                    <td>{{ $client->client_code }}</td>
                    <td>{{ $client->nom }}</td>
                    <td>{{ $client->categoryClient->name }}</td>
                    <td>{{ $client->telephone }}</td>
                    <td>{{ $client->ville }}</td>
                    <td>{{ $client->adresse }}</td>
                    <td>{{ $client->ICE }}</td>
                    <td>
                        <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-primary">Modifier</a>
                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display: inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">
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
        const cityFilter = document.getElementById("cityFilter");
        const searchInput = document.getElementById("search");
        const resetBtn = document.getElementById("resetBtn");
        const table = document.getElementById("client-table");
        const rows = table.getElementsByTagName("tr");

        function filterTable() {
            const selectedCity = cityFilter.value.toLowerCase();
            const searchTerm = searchInput.value.toLowerCase();

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const rowCity = row.getAttribute("data-city").toLowerCase();
                const clientName = row.getElementsByTagName("td")[1].textContent.toLowerCase();

                const cityMatch = selectedCity === "" || rowCity.includes(selectedCity);
                const nameMatch = clientName.includes(searchTerm);

                if (cityMatch && nameMatch) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        }

        cityFilter.addEventListener("change", filterTable);
        searchInput.addEventListener("keyup", filterTable);

        resetBtn.addEventListener("click", function() {
            cityFilter.value = "";
            searchInput.value = "";

            for (let i = 1; i < rows.length; i++) {
                rows[i].style.display = "";
            }
        });
    });
</script>

<style>
    /* Style personnalisé pour la barre de recherche */
    .search-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 0 auto 10px;
        margin-right: auto; /* Ajout de cette ligne */
    }

    .search-bar select {
        flex: 1;
        margin-right: 5px;
    }

    .search-bar input {
        flex: 1;
        margin-right: 5px;
    }

    .search-bar .input-group-append {
        flex: none;
    }

    /* Réglez la largeur des éléments de recherche pour qu'ils s'adaptent à la taille de l'écran */
    @media (max-width: 768px) {
        .search-bar select,
        .search-bar input {
            flex: none;
            width: 100%;
            margin-bottom: 5px;
        }
    }
</style>

@endsection
