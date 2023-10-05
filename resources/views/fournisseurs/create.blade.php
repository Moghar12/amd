@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un fournisseur</h1>

    <form action="{{ route('fournisseurs.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" required>
        </div>

        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" class="form-control" id="adresse" name="adresse" required>
        </div>

        <div class="mb-3">
            <label for="ville">Ville:</label>
            <select name="ville" class="form-control" required>
                <option value="">Sélectionnez une ville</option>
                <option value="Casablanca">Casablanca</option>
                <option value="Rabat">Rabat</option>
                <option value="Marrakech">Marrakech</option>
                <option value="Agadir">Agadir</option>
                <option value="Fès">Fès</option>
                <option value="Tanger">Tanger</option>
                <option value="Meknès">Meknès</option>
                <option value="Oujda">Oujda</option>
                <option value="Kenitra">Kenitra</option>
                <option value="Tétouan">Tétouan</option>
                <option value="Salé">Salé</option>
                <option value="Nador">Nador</option>
                <option value="Mohammedia">Mohammedia</option>
                <option value="El Jadida">El Jadida</option>
                <option value="Témara">Témara</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="ice" class="form-label">ICE</label>
            <input type="text" class="form-control" id="ice" name="ice" required>
        </div>

        <div class="mb-3">
            <label for="tel" class="form-label">Téléphone</label>
            <input type="text" class="form-control" id="tel" name="tel" required>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('fournisseurs.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
