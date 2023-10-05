<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stocks PDF</title>
    <style>
        /* Ajoutez ici vos styles CSS pour le PDF */
    </style>
</head>
<body>
    <h1>Liste des stocks</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix TTC</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stocks as $stock)
                <tr>
                    <td>{{ $stock->product->name }}</td>
                    <td>{{ $stock->quantity }}</td>
                    <td>{{ $stock->product->pph_ttc }} MAD</td>
                    <td>{{ $stock->quantity * $stock->product->pph_ttc }} MAD</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
