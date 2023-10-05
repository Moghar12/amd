@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un produit</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nom :</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control">
        </div>
<br>
        <div class="form-group">
            <label for="purchase_price">Prix d'achat HT :</label>
            <input type="number" name="purchase_price" id="purchase_price" step="0.01" value="{{ old('purchase_price') }}" class="form-control">
        </div>
<br>
        <div class="form-group">
            <label for="pph_ttc">PPH TTC :</label>
            <input type="number" name="pph_ttc" id="pph_ttc" step="0.01" value="{{ old('pph_ttc') }}" class="form-control">
        </div>
{{-- <br>
        <div class="form-group">
            <label for="quantity">Quantité :</label>
            <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" class="form-control">
        </div>
<br> --}}
        <div class="form-group">
            <label for="category_id">Catégorie :</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">Sélectionnez une catégorie</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
<br>
        <div class="form-group">
            <label for="image">Image :</label>
            <input type="file" name="image" id="image" class="form-control-file">
        </div>
<br>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>
@endsection
