@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des produits</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="mb-4" style="max-width: 300px; margin-bottom: 10px;">
        <input type="text" id="search" class="form-control" placeholder="Rechercher un produit">
    </div>
    <a href="{{ route('products.create') }}" class="btn btn-success mb-2">Ajouter produit</a>
    <a href="{{ route('categories.create') }}" class="btn btn-success mb-2">Ajouter catégorie</a>
    <table class="table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Nom</th>
                <th>Catégorie</th>
                <th>Prix d'achat HT</th>
                <th>Prix d'achat TTC</th>
                {{-- <th>Quantité</th> --}}
                <th>PPH TTC</th>
                <th>TVA</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->category->category_code . $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category->name }}</td>
                <td>{{ $product->purchase_price }}</td>
                <td>{{ $product->price_with_taxes }}</td>
                {{-- <td>{{ $product->quantity }}</td> --}}
                <td>{{ $product->pph_ttc }}</td>
                <td>{{ $product->tva }}%</td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">Modifier</a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
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
        const rows = document.getElementsByTagName("tr");

        searchInput.addEventListener("keyup", function() {
            const searchTerm = searchInput.value.toLowerCase();

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const productName = row.getElementsByTagName("td")[1].textContent.toLowerCase();

                if (productName.includes(searchTerm)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        });
    });
</script>
@endsection
