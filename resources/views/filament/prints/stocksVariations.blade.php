<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif des variations de stock</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 11px;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            text-align: center;
            padding: 6px;
        }

        th {
            background-color: #dbe8fb;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f7f9fc;
        }

        tr:nth-child(odd) {
            background-color: #ffffff;
        }

        tr:hover {
            background-color: #f0f6ff;
        }

        tfoot td {
            font-weight: bold;
            background-color: #c8dbf9;
        }

        .header-info {
            position: absolute;
            top: 10px;
            right: 20px;
            text-align: left;
            font-size: 12px;
        }

        .header-info p {
            margin: 2px 0;
        }

        .title {
            text-align: center;
            margin-top: 40px;
        }

        .footer-date {
            position: absolute;
            bottom: 10px;
            left: 10px;
            font-size: 12px;
        }

        .type-add {
            color: #0b7a0b;
            font-weight: bold;
        }

        .type-sub {
            color: #c62828;
            font-weight: bold;
        }

        .variation-positive {
            color: #0b7a0b;
            font-weight: bold;
        }

        .variation-negative {
            color: #c62828;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- En-tête infos -->
    <div class="header-info">
        <p><strong>Date :</strong> {{ now()->format('d/m/Y') }}</p>
        <p><strong>Nombre de variations :</strong> {{ $data->count() }}</p>
    </div>

    <!-- Titre -->
    <div class="title">
        <h3><strong>RÉCAPITULATIF DES VARIATIONS DE STOCK</strong></h3>
    </div>

    <!-- Tableau -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Produit</th>
                <th>Type</th>
                <th>Stock avant</th>
                <th>Variation</th>
                <th>Nouveau stock</th>
                <th>Utilisateur</th>
                <th>Date</th>
            </tr>
        </thead>

        <tbody>
            @php $num = 1; @endphp
            @foreach ($data as $variation) 
                <tr>
                    <td>{{ $num++ }}</td>
                    <td>{{ $variation->nom ?? '-' }}</td>
                    <td class="{{ $variation->type === 'add' ? 'type-add' : 'type-sub' }}">
                        {{ strtoupper($variation->type) }}
                    </td>
                    <td>{{ number_format($variation->current_stock_value, 0, ',', ' ') }}</td>
                    <td class="{{ $variation->type == 'Add' ? 'variation-positive' : 'variation-negative' }}">
                        {{ $variation->type == 'Add' ? '+' : '-' }}
                        {{ number_format(abs($variation->variation_stock_value), 0, ',', ' ') }}
                    </td>
                    <td>{{ number_format($variation->new_stock_value, 0, ',', ' ') }}</td>
                    <td>{{ $variation->name ?? 'Utilisateur inconnu' }}</td>
                    <td>{{ \Carbon\Carbon::parse($variation->created_at)->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="7" style="text-align: right;">TOTAL VARIATIONS</td>
                <td>{{ $data->count() }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- Pied de page -->
    <div class="footer-date">
        <p>Édité le {{ \Carbon\Carbon::now()->locale('fr_FR')->isoFormat('D MMMM YYYY') }}</p>
    </div>

</body>
</html>
