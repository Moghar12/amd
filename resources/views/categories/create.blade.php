@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter une catégorie</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nom de la catégorie</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div class="form-group">
            <label for="category_code">Code de la catégorie</label>
            <input type="text" class="form-control" id="category_code" name="category_code" value="{{ old('category_code') }}" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
