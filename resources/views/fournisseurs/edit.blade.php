@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le fournisseur</h1>

    <form action="{{ route('fournisseurs.update', $fournisseur->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ $fournisseur->nom }}" required>
        </div>

        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" class="form-control" id="adresse" name="adresse" value="{{ $fournisseur->adresse }}" required>
        </div>

        <div class="mb-3">
            <label for="ville">Ville :</label>
            <select name="ville" class="form-control" required>
                <option value="">Sélectionnez une ville</option>
                <option value="Casablanca" @if($fournisseur->ville == "Casablanca") selected @endif>Casablanca</option>
                <option value="Rabat" @if($fournisseur->ville == "Rabat") selected @endif>Rabat</option>
                <option value="Marrakech" @if($fournisseur->ville == "Marrakech") selected @endif>Marrakech</option>
                <option value="Agadir" @if($fournisseur->ville == "Agadir") selected @endif>Agadir</option>
                <option value="Fès" @if($fournisseur->ville == "Fès") selected @endif>Fès</option>
                <option value="Tanger" @if($fournisseur->ville == "Tanger") selected @endif>Tanger</option>
                <option value="Meknès" @if($fournisseur->ville == "Meknès") selected @endif>Meknès</option>
                <option value="Oujda" @if($fournisseur->ville == "Oujda") selected @endif>Oujda</option>
                <option value="Kenitra" @if($fournisseur->ville == "Kenitra") selected @endif>Kenitra</option>
                <option value="Tétouan" @if($fournisseur->ville == "Tétouan") selected @endif>Tétouan</option>
                <option value="Salé" @if($fournisseur->ville == "Salé") selected @endif>Salé</option>
                <option value="Nador" @if($fournisseur->ville == "Nador") selected @endif>Nador</option>
                <option value="Mohammedia" @if($fournisseur->ville == "Mohammedia") selected @endif>Mohammedia</option>
                <option value="El Jadida" @if($fournisseur->ville == "El Jadida") selected @endif>El Jadida</option>
                <option value="Témara" @if($fournisseur->ville == "Témara") selected @endif>Témara</option>
            </select>
        </div>
        

        <div class="mb-3">
            <label for="ice" class="form-label">ICE</label>
            <input type="text" class="form-control" id="ice" name="ice" value="{{ $fournisseur->ice }}" required>
        </div>

        <div class="mb-3">
            <label for="tel" class="form-label">Téléphone</label>
            <input type="text" class="form-control" id="tel" name="tel" value="{{ $fournisseur->tel }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('fournisseurs.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
