<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
 body {
            font-family: Arial, sans-serif;
            background-image: url('app/imm/logo.png'); /* Ajoutez le chemin correct vers votre image */
            background-size: cover; /* Ajuste la taille de l'image pour remplir l'écran */
            background-repeat: no-repeat;
            background-attachment: fixed;
        }



.firma {
    text-align: center;
    font-weight: bold;
    font-size: 24px;
    margin-top: 40px;
}

.footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    /* background-color: #f2f2f2; Fond gris clair */
    padding: 12px; /* Espacement intérieur */
    text-align: center;
    font-weight: bold;
}

.address {
    font-size: 14px;
    margin-top: 10px;
}

.info-container {
            float: left; /* Aligner à droite */
        }

        .client-container {
            float: right; /* Aligner à gauche */
        }


    </style>
    
</head>
<body class="container mt-5">
    <div style="font-size:50px; text-align: center;">AMD PHARMA</div>
    <br><br><br><br>
    <div class="info mt-4 border border-dark p-2 info-container">
        <div class="info-item">Date: {{ $bonSortie->date }}</div>
        <div class="info-item">Numéro: {{ $bonSortie->numero_document }}</div>
        <div class="info-item">Représentant: Ahmed</div>
    </div>
    
    {{-- <div class="client-info mt-4 border border-dark p-2 client-container centered-table">
        <div class="client-item">Client: {{ $bonSortie->client->nom }},{{ $bonSortie->client->ville }}</div>
        <div class="client-item">ICE: {{ $bonSortie->client->ICE }}</div> --}}
        <table  style="float: right;" border="1">

            <tr style=" font-weight: bold;
            background-color: #f2f2f2; /* Fond gris clair */
            padding: 12px; /* Augmente la hauteur de la cellule */">
            <th>CLIENT</th>
            </tr>
            <tr>
            <td style="padding: 10px">{{ $bonSortie->client->nom }},{{ $bonSortie->client->ville }} <br>{{ $bonSortie->client->adresse }}<br>
                @if (strpos($bonSortie->numero_document, 'FC') === 0)
                @php
                    echo 'ICE: ' . $bonSortie->client->ICE;
                @endphp
            @endif
            
            </td>
        </tr>
        </table>
    </div>
<br><br><br>


<br><br><br>
{{-- <div class="d-flex justify-content-center">
    <div class="client-item" style="float: right;">Représentant: Ahmed</div><br><br> --}}
    @if (strpos($bonSortie->numero_document, 'FC') === 0)
@php
    echo '<div style="font-size:30px; text-align: center;">FACTURE</div>';
@endphp
@endif
    @if (strpos($bonSortie->numero_document, 'BL') === 0)
@php
    echo '<div style="font-size:30px; text-align: center;">BON DE LIVRAISON</div>';
@endphp
@endif
<br>
    <table border="1" style="width: 100%; max-width: 800px;">
        <tbody>
        <tr style=" font-weight: bold;
        background-color: #f2f2f2; /* Fond gris clair */
        padding: 12px; /* Augmente la hauteur de la cellule */">
            <td colspan="3">DESIGNATION</td>
            <td>Qte</td>
            <td colspan="2">PPH TTC</td>
            <td>REMISE</td>
            <td>MONTANT</td>
        </tr>
        @foreach($bonSortie->products as $product)
        <tr>
                <td colspan="3">{{ $product->name }}</td>
                <td>{{ $product->pivot->quantite }}</td>
                <td colspan="2">{{ $product->pivot->prix_unitaire }}</td>
                <td>{{ $product->pivot->remise }}%</td>
                <td>{{ number_format(($product->pivot->prix_unitaire * $product->pivot->quantite) - ($product->pivot->remise / 100 * ($product->pivot->prix_unitaire * $product->pivot->quantite)), 2) }} </td>
                
            </tr>
             
        @endforeach
        <br><br><br><br><br><br><br><br> 
    </tbody>
        <tfoot>
        <tr>
            <td style=" font-weight: bold;
            background-color: #f2f2f2; /* Fond gris clair */
            padding: 12px; /* Augmente la hauteur de la cellule */">Total HT</td>
            <td style=" font-weight: bold;
            background-color: #f2f2f2; /* Fond gris clair */
            padding: 12px; /* Augmente la hauteur de la cellule */">Base</td>
            <td style=" font-weight: bold;
            background-color: #f2f2f2; /* Fond gris clair */
            padding: 12px; /* Augmente la hauteur de la cellule */">TVA</td>
            <td style=" font-weight: bold;
            background-color: #f2f2f2; /* Fond gris clair */
            padding: 12px; /* Augmente la hauteur de la cellule */">Total</td>
            <td style=" font-weight: bold;
            background-color: #f2f2f2; /* Fond gris clair */
            padding: 12px; /* Augmente la hauteur de la cellule */">ESCPT</td>
            <td style=" font-weight: bold;
            background-color: #f2f2f2; /* Fond gris clair */
            padding: 12px; /* Augmente la hauteur de la cellule */">{{$bonSortie->escpt}}</td>
            <td rowspan="2"></td>
            <td style=" font-weight: bold;
            background-color: #f2f2f2; /* Fond gris clair */
            padding: 12px; /* Augmente la hauteur de la cellule */">{{ number_format($bonSortie->prix_total, 2) }}</td>
        </tr>
        <tr>
            <td>{{ number_format($bonSortie->prix_total / 1.2, 2) }}</td>
            <td>{{ number_format($bonSortie->prix_total / 1.2, 2) }}</td>
            <td>{{ number_format(($bonSortie->prix_total / 1.2) * 0.20, 2) }}</td>
            <td>{{ number_format($bonSortie->prix_total) }}</td>
            
            @if ($bonSortie->escpt == '3%')
            @php
                echo '<td colspan="2">' . number_format((($bonSortie->prix_total / 1.2) + (($bonSortie->prix_total / 1.2) * 0.20)) * 0.03, 2);
            @endphp
        @endif
        @if ($bonSortie->escpt == '0%')
            @php
                echo '<td colspan="2">' . number_format((($bonSortie->prix_total / 1.2) + (($bonSortie->prix_total / 1.2) * 0.20)) * 0.00, 2);
            @endphp
        @endif
        @if ($bonSortie->escpt == '5%')
            @php
                echo '<td colspan="2">' . number_format((($bonSortie->prix_total / 1.2) + (($bonSortie->prix_total / 1.2) * 0.20)) * 0.05, 2);
            @endphp
        @endif
        
            </td>
            {{-- <td></td> --}}
            <td style="font-weight: bold;">NET A PAYER</td>
        </tr>
        <tr>
            <td class="masquer sans-bordure" colspan="7"></td>
            <td style=" font-weight: bold;
            background-color: #f2f2f2; /* Fond gris clair */
            padding: 12px; /* Augmente la hauteur de la cellule */">{{ number_format(($bonSortie->prix_total) - (($bonSortie->prix_total / 1.2) + (($bonSortie->prix_total / 1.2) * 0.20)) * 0.03, 2) }}</td>
        </tr>
    </tfoot>  
    </table>
    </div>
<br><br><br>
<table class="mode table-margin" border="1">

    <tr style=" font-weight: bold;
    background-color: #f2f2f2; /* Fond gris clair */
    padding: 12px; /* Augmente la hauteur de la cellule */">
    <th>MODALITE DE PAIMENT</th>
    </tr>
    <tr>
    <td>{{ $bonSortie->modalite_paiement }}</td>
</tr>
</table>

<div class="footer">
    <div class="firma"> AMD PHARMA <br></div>
    <div class="address">
        Rabat - Agdal, 22 Rue Oued Ziz, N° 01 
        Tel : 0537 682 451 / GSM : 0661393153 
        @if (strpos($bonSortie->numero_document, 'FC') === 0)
        @php
            echo '<br>RC N° 168183, Identifiant fiscal : 53755352, ICE: 003288122000053';
        @endphp
    @endif
    

        <br>Contact : amdpharma.maroc@gmail.com
    </div>
</div>


</body>

</html>
