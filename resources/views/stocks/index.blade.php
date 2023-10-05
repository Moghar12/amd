@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des stocks</h1>

        @php
            $totalStockValue = 0;
        @endphp

        @foreach ($stocks as $stock)
            @php
                $totalStockValue += $stock->quantity * $stock->product->pph_ttc;
            @endphp
        @endforeach

        @php
        $totalStockValue0 = 0;
    @endphp

    @foreach ($stocks as $stock)
        @php
            $totalStockValue0 += $stock->quantity * $stock->product->purchase_price;
        @endphp
    @endforeach
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <strong>Valeur totale du stock PPH:</strong> {{    number_format($totalStockValue, 0, ',', ' ') }}  MAD
                   <br> <strong>Valeur totale du stock PRIX D'ACHAT:</strong> {{    number_format($totalStockValue0, 0, ',', ' ') }}  MAD
                   <br> <strong>La marge:</strong> {{    number_format($totalStockValue - $totalStockValue0, 0, ',', ' ') }}  MAD
                </div>
                   
        </div>
        {{-- <div class="mb-2">
            <a href="{{ route('stocks.download-pdf') }}" class="btn btn-success">Télécharger</a>
        </div> --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" class="form-control" id="search" placeholder="Rechercher un produit">
            </div>
        </div>
        <table class="table" id="be-table">
            <thead class="thead-dark">
                <tr >
                    <th>Produit</th>
                    <th style="text-align: right">Quantité</th>
                    <th style="text-align: right">PRIX D'ACHAT</th>
                    <th style="text-align: right">PPH TTC</th>
                    <th style="text-align: right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stocks as $stock)
                    <tr class="data-row">
                        <td>{{ $stock->product->name }}</td>
                        <td style="text-align: right">{{ number_format($stock->quantity, 0, ',', ' ') }}</td>
                        <td style="text-align: right">{{ number_format($stock->product->purchase_price, 2, ',', ' ') }}</td>
                        <td style="text-align: right">{{ number_format($stock->product->pph_ttc, 2, ',', ' ') }}</td>
                        <td style="text-align: right">{{ number_format($stock->quantity * $stock->product->pph_ttc, 2, ',', ' ') }}</td>                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("search");
            const rows = document.querySelectorAll(".data-row");

            searchInput.addEventListener("input", function () {
                const searchTerm = this.value.toLowerCase();

                rows.forEach(row => {
                    const productName = row.querySelector("td:first-child").textContent.toLowerCase();
                    row.style.display = productName.includes(searchTerm) ? "" : "none";
                });
            });
        });
    </script>
@endsection
