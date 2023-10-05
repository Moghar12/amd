@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des fournisseurs</h1>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

  
    <div class="mb-4" style="max-width: 300px; margin-bottom: 10px;">
        <div class="input-group">
            <input type="text" id="search" name="search" class="form-control" placeholder="Rechercher un fournisseur">
        </div>
    </div>
    <div class="mb-2">
        <a href="{{ route('fournisseurs.create') }}" class="btn btn-success">Ajouter fournisseur</a>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Ville</th>
                <th>ICE</th>
                <th>Tel</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fournisseurs as $fournisseur)
                <tr>
                    <td>{{ $fournisseur->nom }}</td>
                    <td>{{ $fournisseur->adresse }}</td>
                    <td>{{ $fournisseur->ville }}</td>
                    <td>{{ $fournisseur->ice }}</td>
                    <td>{{ $fournisseur->tel }}</td>
                    <td>
                        <a href="{{ route('fournisseurs.edit', $fournisseur->id) }}" class="btn btn-primary">Modifier</a>
                        <form action="{{ route('fournisseurs.destroy', $fournisseur->id) }}" method="POST" style="display: inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fournisseur ?')">
                                <span style="font-weight: bold;">Supprimer</span>
                            </button>
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
        const rows = document.getElementsByTagName("tr");

        searchInput.addEventListener("keyup", function() {
            const searchTerm = searchInput.value.toLowerCase();

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const fournisseurNom = row.getElementsByTagName("td")[0].textContent.toLowerCase();

                if (fournisseurNom.includes(searchTerm)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        });
    });
</script>
@endsection
