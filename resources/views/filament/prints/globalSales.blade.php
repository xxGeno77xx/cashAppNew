
@php
use Carbon\Carbon
@endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif des ventes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 10px;
            margin-top: -10px;
        }

        th, td {
            border: 1px solid black;
            text-align: center;
            padding: 4px;
        }

        th {
            background-color: #e0ecf9;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        tfoot td {
            font-weight: bold;
            background-color: #d0e1f5;
        }

        .header-info {
            position: absolute;
            top: 5px;
            right: 10px;
            text-align: left;
            font-size: 12px;
        }

        .header-info p {
            margin: 2px 0;
        }

        .logo {
            margin-top: -90px;
            display: block;
            width: auto;
            height: 90px;
        }

        .title {
            margin-top: -20px;
            text-align: center;
        }

        .footer-date {
            position: absolute;
            bottom: 10px;
            left: 10px;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <!-- Logo -->
    <div class="logo">
      <!--    <img src="{{ asset('images/ems_logo.png') }}" alt="Logo">-->
    </div>

    <!-- En-tête informations -->
    <div class="header-info">
        <p><strong>Période du :</strong> {{ Carbon::parse($start)->format('d/m/Y') }} au {{ Carbon::parse($end)->format('d/m/Y') }}</p>
        <p><strong>Total commandes :</strong> {{ $data->count() }}</p>
    </div>
<br>
<br>
    <!-- Titre -->
    <div class="title">
        <h4><strong>RÉCAPITULATIF DES VENTES JOURNALIÈRES</strong></h4>
    </div>

    <!-- Tableau -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Sous-total</th>
                <th>Total commande</th>
            </tr>
        </thead>
        <tbody>
            @php $num = 1; @endphp
            @foreach ($data as $sale)
                @foreach ($sale->details as $index => $detail)
                    <tr>
                        @if($index === 0)
                            <td rowspan="{{ count($sale->details) }}">{{ $num++ }}</td>
                            <td rowspan="{{ count($sale->details) }}">
                                {{ $sale->prenom  ?? '-'}} {{ $sale->nom ?? '-' }}
                            </td>
                        @endif
                        <td>{{ $detail['nom_produit'] }}</td>
                        <td>{{ $detail['quantite'] }}</td>
                        <td>{{ number_format($detail['prix_unitaire'], 0, ',', ' ') }}</td>
                        <td>{{ number_format($detail['sous_total'], 0, ',', ' ') }}</td>
                        @if($index === 0)
                            <td rowspan="{{ count($sale->details) }}" style="font-weight: bold;">
                                {{ number_format($sale->total_prix, 0, ',', ' ') }}
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" style="text-align: right;">TOTAL GÉNÉRAL</td>
                <td style="font-weight: bold;">
                    {{ number_format($data->first()->total_general ?? 0, 0, ',', ' ') }}
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- Pied de page -->
    <div class="footer-date">
        <p>Édité le {{ \Carbon\Carbon::now()->locale('fr_FR')->isoFormat('D MMMM YYYY') }}</p>
    </div>

</body>
</html>
