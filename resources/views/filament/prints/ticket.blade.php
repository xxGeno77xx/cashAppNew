@php
    use App\Models\Client;
    use App\Models\Produit;

    $client = Client::find($commande->client_id);

    $total = 0;
    foreach ($commande->details as $produit) {
        $total += $produit['sous_total'];
    }
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ticket</title>

    <style>
        @page {
            size: 70mm auto;
            margin: 0;
        }

        body {
            background: white;
            font-family: "Courier New", monospace;
            font-size: 13px;
            margin: 0;
            padding: 0;
            width: 66mm;
            box-sizing: border-box;
        }

        .ticket {
            width: 66mm;
            padding: 6px;
            margin: 0;
            box-sizing: border-box;
        }

        .qr-code {
            text-align: center;
            margin-bottom: 6px;
        }

        .qr-code img {
            width: 70px;
            opacity: 0.9;
        }

        .date {
            text-align: center;
            margin-bottom: 6px;
        }

        .token-box {

            padding: 5px;
            margin: 8px 0;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
        }

        hr {
            border: none;
            border-top: 1px solid #aaa;
            margin: 10px 0;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin: 4px 0;
            font-size: 14px;

        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            font-size: 14px;
            text-align:center;
        }

        table th,
        table td {
            padding: 3px 0;
            border: 1px solid #aaa;
        }

        table th {
            text-align: center;
            border: 1px solid #aaa;
        }

        table td:last-child {
            text-align: right;
            border: 1px solid #aaa;
        }

        .summary {
            margin-top: 8px;
            border-top: 1px solid #aaa;
            padding-top: 6px;
            font-size: 10px;
            font-weight: bold;
        }

        .acme {
            text-align: center;
            margin-top: 12px;
            font-size: 14px;
            font-weight: 900;
            font-family: Arial Black, sans-serif;
        }

        .small {
            font-size: 11px;
            text-align: center;
            margin-top: 8px;
        }

        @media print {
            body { margin: 0; padding: 0; }
            .ticket { border: none; }
        }
    </style>
</head>

<body>

<div class="ticket">

    <div class="acme">FASHION HOUSE</div>


    <div class="small">
        Alimentation Générale / Prêt à porter <br>
        Boutique sise au grand marché de Lomé <br>
        Tel: 90 11 89 80 <br>
        NIF: 1000093024
    </div>

    <div class="qr-code">
        <img src="images/receit.jpg" alt="logo">
    </div>

    <div class="date">
        Émis le : <strong>{{ now()->format('d/m/Y à H:i') }}</strong>
    </div>

    <div class="token-box">
        Facture N° {{ $commande->id }}
    </div>



    <div>
        <strong>Client : </strong>{{ $client?->nom ?? '-' }} {{ $client?->prenom ?? '-' }}<br> <br>
        <strong>Téléphone : </strong>{{ $client?->telephone ?? '-' }}
    </div>

    <br>

    <table>
        <thead>
            <tr>
                <th>Qté</th>
                <th>Article</th>
                <th>P.U</th>
                <th style="text-align:right;">Sous-total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($commande->details as $produit)
                @php
                    $prod = Produit::find($produit['produit_id']);

                    $optionLabel = '';

                    if(array_key_exists("option", $produit))
                    {
                        if (in_array($produit['option'],[1]))
                        {
                            $optionLabel = '';
                        }
                         else if (in_array($produit['option'],[2,5]))
                        {
                            $optionLabel = '1/2';
                        }
                         else if (in_array($produit['option'],[3,4]))
                        {
                            $optionLabel = '1/4';
                        }
                    }



                        @endphp
                <tr>
                    <td>{{ $produit['quantite'] }}</td>
                    <td>{{ $prod->nom ?? 'Produit inconnu' }} {{ $optionLabel }}</td>
                    <td>{{ $produit['prix_unitaire'] ?? 'Prix inconnu' }}</td>
                    <td>{{ number_format($produit['sous_total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="row">
            <span>Total</span>
            <span>{{ number_format($total, 0, ',', '.') }} FCFA</span>
        </div>
    </div>

    <br>
    <br>

    <div class="row">
        <span>Vendeur :</span>
        <span>{{ $userName }}</span>
    </div>
   <br>
    <br>


    <div class="acme">Nous vous remercions pour votre achat</div>


</div>

</body>
</html>
