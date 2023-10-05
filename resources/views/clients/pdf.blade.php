<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Liste des clients</h1>
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Nom</th>
                <th>Ville</th>
                <th>Adresse</th>
                <th>ICE</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->code }}</td>
                    <td>{{ $client->nom }}</td>
                    <td>{{ $client->ville }}</td>
                    <td>{{ $client->adresse }}</td>
                    <td>{{ $client->ICE }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
