@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le client</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('clients.update', $client->id) }}" method="POST">
        @csrf
        @method('PUT')
<br>
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ $client->nom }}" required>
        </div>
<br>

        <div class="form-group">
            <label for="ville">Ville:</label>
            <select name="ville" class="form-control" required>
                <option value="">Sélectionnez une ville</option>
                <option value="Casablanca" @if($client->ville == "Casablanca") selected @endif>Casablanca</option>
                <option value="Rabat" @if($client->ville == "Rabat") selected @endif>Rabat</option>
                <option value="Marrakech" @if($client->ville == "Marrakech") selected @endif>Marrakech</option>
                <option value="Agadir" @if($client->ville == "Agadir") selected @endif>Agadir</option>
                <option value="Fès" @if($client->ville == "Fès") selected @endif>Fès</option>
                <option value="Tanger" @if($client->ville == "Tanger") selected @endif>Tanger</option>
                <option value="Meknès" @if($client->ville == "Meknès") selected @endif>Meknès</option>
                <option value="Oujda" @if($client->ville == "Oujda") selected @endif>Oujda</option>
                <option value="Kenitra" @if($client->ville == "Kenitra") selected @endif>Kenitra</option>
                <option value="Tétouan" @if($client->ville == "Tétouan") selected @endif>Tétouan</option>
                <option value="Salé" @if($client->ville == "Salé") selected @endif>Salé</option>
                <option value="Nador" @if($client->ville == "Nador") selected @endif>Nador</option>
                <option value="Mohammedia" @if($client->ville == "Mohammedia") selected @endif>Mohammedia</option>
                <option value="El Jadida" @if($client->ville == "El Jadida") selected @endif>El Jadida</option>
                <option value="Témara" @if($client->ville == "Témara") selected @endif>Témara</option>
            </select>
        </div>
        <br>
        <div class="form-group">
            <label for="category_id">Catégorie:</label><br>
            @foreach ($categories as $category)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="category_id" value="{{ $category->id }}" {{ $category->id == $client->category_id ? 'checked' : '' }} required>
                    <label class="form-check-label" for="category_{{ $category->id }}">{{ $category->name }}</label>
                </div>
            @endforeach
        </div>
        <br>
        
        <div class="form-group">
            <label for="adresse">Adresse</label>
            <input type="text" name="adresse" id="adresse" class="form-control" value="{{ $client->adresse }}" required>
        </div>
        <br>
        <div class="form-group">
            <label for="telephone">Téléphone:</label>
            <input type="text" name="telephone" id="telephone" class="form-control" value="{{ $client->telephone }}" required>
        </div>
        <br>
        <div class="form-group">
            <label for="ICE">ICE</label>
            <input type="text" name="ICE" id="ICE" class="form-control" value="{{ $client->ICE }}" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
