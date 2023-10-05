@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le produit</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <br>
        <div class="form-group">
            <label for="name">Nom du produit</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
        </div>
        <br>
        <div class="form-group">
            <label for="category">Catégorie</label>
            <select class="form-control" id="category" name="category_id" required>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>
        <br>
        <div class="form-group">
            <label for="purchase_price">Prix d'achat HT</label>
            <input type="number" class="form-control" id="purchase_price" name="purchase_price"
                value="{{ $product->purchase_price }}" required>
        </div>
        <br>
        {{-- <div class="form-group">
            <label for="quantity">Quantité</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $product->quantity }}"
                required>
        </div>
        <br> --}}
        <div class="form-group">
            <label for="pph_ttc">PPH TTC</label>
            <input type="number" class="form-control" id="pph_ttc" name="pph_ttc" value="{{ $product->pph_ttc }}"
                required>
        </div>
        <br>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control-file" id="image" name="image">
        </div>
<br>
        <button type="submit" class="btn btn-primary">Modifier</button>
    </form>
</div>
@endsection
