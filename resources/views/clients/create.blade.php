@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Ajouter un client</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('clients.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
<br>
            <div class="form-group">
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
            <br>
            <div class="form-group">
                <label for="category_id">Catégorie:</label><br>
                @foreach ($categories as $category)
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="category_id" value="{{ $category->id }}" required>
                        <label class="form-check-label" for="category_{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>
<br>
            <div class="form-group">
                <label for="adresse">Adresse:</label>
                <input type="text" name="adresse" class="form-control" required>
            </div>
            <br>
            <div class="form-group">
                <label for="telephone">Téléphone:</label>
                <input type="text" name="telephone" id="telephone" class="form-control" required>
            </div>
<br>
            <div class="form-group">
                <label for="ICE">ICE:</label>
                <input type="text" name="ICE" class="form-control" required>
            </div>
<br>
            <button type="submit" class="btn btn-primary">Ajouter client</button>
        </form>
    </div>
    <script>
        function validateForm() {
            var phoneNumber = document.getElementById('telephone').value;
            var phoneNumberPattern = /^(05|06|07|08)[0-9]{8}$/;

            if (!phoneNumberPattern.test(phoneNumber)) {
                alert('Le numéro de téléphone doit commencer par 05, 06, 07 ou 08 et comporter 10 chiffres.');
                return false; // Empêche la soumission du formulaire
            }

            return true; // Soumet le formulaire
        }
    </script>
@endsection
