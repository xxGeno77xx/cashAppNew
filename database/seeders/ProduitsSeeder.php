<?php

namespace Database\Seeders;

use App\Models\Produit;
use App\Models\Stock;
use Illuminate\Database\Seeder;

class ProduitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coiffure = [

            // coiffure
            'Passion',
            'Family BOA',
            'Gel noir',
            'Gel blanc',
            'AFRO Lady',
            'Black wash',
            'Perle',
            'chouchouvi',
            'Attache chouchouvi',
            'Peigne',
            'Tam-tam',
            'AIFIASSI',
            'Kaquier',
            'Bovi',

        ];

        $coiffureStock = [
            3,
            2,
            2,
            1,
            1,
            10,
            6,
            3,
            6,
            3,
            4,
            3,
            3,
            6,
        ];

        $couhes = [

            // couches
            'Cuettie',
            'Softcare',
            'Naval Girl',
            'Max Plus',
        ];

        $couhesStock = [
            200,
            12,
            9,
            12,
        ];

        $defrisants = [
            'B3 Super',
            'B3 Normal',
            'Bo 16',
            'ABC',
            'USA',
            'Mega',
        ];

        $defrisantsStock = [
            3,
            3,
            6,
            6,
            6,
            12,
        ];

        $savonsOmo = [
            'Baléa',
            'Protex herbal',
            'Protex classic',
            'Anita avocat',
            'Anita rose',
            'Viva',
            'Viva plus',
        ];

        $savonsOmoStock = [
            56,
            6,
            6,
            6,
            12,
            24,
            7,
        ];

        $Biscuits = [
            'Colombina',
            'Milk',
            'Moka',
            'Amster D',
            'Chaocolate C',
            'PERK',
        ];

        $BiscuitsStock = [
            144,
            72,
            150,
            120,
            72,
            72,
        ];

        $chaussures = [
            'Fermés',
            'Cathérine',
            'ARIZONA',
            'MH',
        ];

        $chaussuresStock = [
            5,
            3,
            4,
            4,
        ];

        $Meches = [
            'Outré',
            'tressage',
            'Kinky',
            'Multi',
        ];

        $MechesStock = [
            50,
            10,
            2,
            2,
        ];

        $ustensiles = [
            'Glace',
            'Bols céramiques',
            'Plats',
            'Gobelets plastiques',
            'Louches en bois',
            'Plats creux',
            'Jettables',
            'Gobelets 5x5',
        ];

        $ustensilesStock = [
            6,
            6,
            12,
            12,
            3,
            6,
            10,
            6,
        ];

        $nutrition = [
            'Cebon',
            'PEAK en poudre',
            'MILO',
            'OVALTINE',
            'BAMA',
            'SUGREX',
        ];

        $nutritionStock = [
            12,
            3,
            3,
            3,
            3,
            3,
        ];

        $liqueurs = [
            'VEGAS',
            'TOSO (R)',
            'TOSO (B)',
            'CORTEZANO (R)',
            'CORTEZANO (B)',
            'ORIS DRY GIN',
            'LEGEND',
            'HONEY',
            'FIESTA',
            'MUSCADOR (B)',
            'MUSCADOR (R)',
        ];

        $liqueursStock = [
            3,
            2,
            1,
            2,
            1,
            3,
            3,
            3,
            3,
            1,
            2,
        ];

        $vins = [
            'HUGO',
            'Gd VERSANT',
            'CHATEU Chev',
            'Gd MANOIR',
            'Jrnie Spirale',
            'SOLA de RICOT',
            'BONITA',
            'Domaine du Moulin',
            'SANGRIA',
        ];

        $vinsStock = [
            12,
            6,
            9,
            3,
            6,
            6,
            3,
            3,
            12,
        ];

        $cannettes = [
            'World',
            'Castel',
            'Sunset Max',
            'VODY',
            'Yuki Pomp',
            'MLATA',
            'Sprite',
            'COCKTAIL',
            'BEAUFORT',
            'PILS',
            'YUKI ORANGE',
        ];

        $cannettesStock = [
            24,
            24,
            6,
            6,
            24,
            48,
            24,
            48,
            24,
            24,
            24,
        ];

        $sacs = [
            'Pochettes',
            'Bandoulière',
        ];

        $sacsStock = [
            3,
            3,
        ];

        foreach ($coiffure as $key => $nom) {

            Produit::firstOrCreate([
                'nom' => $nom,
                'description' => null,
                'image' => null,
                'prix_unitaire' => 0,
                'categorie_id' => 1,
            ]);

            Stock::firstOrCreate([
                'produit_id' => Produit::where('nom', $nom)->first()->id,
                'quantite_en_stock' => $coiffureStock[$key],

            ]);
        }

        foreach ($couhes as $key => $nom) {

            Produit::firstOrCreate([
                'nom' => $nom,
                'description' => null,
                'image' => null,
                'prix_unitaire' => 0,
                'categorie_id' => 2,
            ]);

            Stock::firstOrCreate([
                'produit_id' => Produit::where('nom', $nom)->first()->id,
                'quantite_en_stock' => $couhesStock[$key],

            ]);
        }

        foreach ($defrisants as $key => $nom) {

            Produit::firstOrCreate([
                'nom' => $nom,
                'description' => null,
                'image' => null,
                'prix_unitaire' => 0,
                'categorie_id' => 3,
            ]);

            Stock::firstOrCreate([
                'produit_id' => Produit::where('nom', $nom)->first()->id,
                'quantite_en_stock' => $defrisantsStock[$key],

            ]);

        }

        foreach ($savonsOmo as $key => $nom) {

            Produit::firstOrCreate([
                'nom' => $nom,
                'description' => null,
                'image' => null,
                'prix_unitaire' => 0,
                'categorie_id' => 4,
            ]);

            Stock::firstOrCreate([
                'produit_id' => Produit::where('nom', $nom)->first()->id,
                'quantite_en_stock' => $savonsOmoStock[$key],

            ]);
        }

        foreach ($Biscuits as $key => $nom) {

            Produit::firstOrCreate([
                'nom' => $nom,
                'description' => null,
                'image' => null,
                'prix_unitaire' => 0,
                'categorie_id' => 5,
            ]);

            Stock::firstOrCreate([
                'produit_id' => Produit::where('nom', $nom)->first()->id,
                'quantite_en_stock' => $BiscuitsStock[$key],

            ]);

        }

        foreach ($chaussures as $key => $nom) {

            Produit::firstOrCreate([
                'nom' => $nom,
                'description' => null,
                'image' => null,
                'prix_unitaire' => 0,
                'categorie_id' => 6,
            ]);

            Stock::firstOrCreate([
                'produit_id' => Produit::where('nom', $nom)->first()->id,
                'quantite_en_stock' => $chaussuresStock[$key],

            ]);

        }

        foreach ($Meches as $key => $nom) {

            Produit::firstOrCreate([
                'nom' => $nom,
                'description' => null,
                'image' => null,
                'prix_unitaire' => 0,
                'categorie_id' => 7,
            ]);

            Stock::firstOrCreate([
                'produit_id' => Produit::where('nom', $nom)->first()->id,
                'quantite_en_stock' => $MechesStock[$key],

            ]);

        }

        foreach ($ustensiles as $key => $nom) {

            Produit::firstOrCreate([
                'nom' => $nom,
                'description' => null,
                'image' => null,
                'prix_unitaire' => 0,
                'categorie_id' => 8,
            ]);

            Stock::firstOrCreate([
                'produit_id' => Produit::where('nom', $nom)->first()->id,
                'quantite_en_stock' => $ustensilesStock[$key],

            ]);

        }

        foreach ($nutrition as $key => $nom) {

            Produit::firstOrCreate([
                'nom' => $nom,
                'description' => null,
                'image' => null,
                'prix_unitaire' => 0,
                'categorie_id' => 9,
            ]);

            Stock::firstOrCreate([
                'produit_id' => Produit::where('nom', $nom)->first()->id,
                'quantite_en_stock' => $nutritionStock[$key],

            ]);

        }

        foreach ($liqueurs as $key => $nom) {

            Produit::firstOrCreate([
                'nom' => $nom,
                'description' => null,
                'image' => null,
                'prix_unitaire' => 0,
                'categorie_id' => 10,
            ]);

            Stock::firstOrCreate([
                'produit_id' => Produit::where('nom', $nom)->first()->id,
                'quantite_en_stock' => $liqueursStock[$key],

            ]);
        }

        foreach ($vins as $key => $nom) {

            Produit::firstOrCreate([
                'nom' => $nom,
                'description' => null,
                'image' => null,
                'prix_unitaire' => 0,
                'categorie_id' => 11,
            ]);

            Stock::firstOrCreate([
                'produit_id' => Produit::where('nom', $nom)->first()->id,
                'quantite_en_stock' => $vinsStock[$key],

            ]);

        }
        foreach ($cannettes as $key => $nom) {

            Produit::firstOrCreate([
                'nom' => $nom,
                'description' => null,
                'image' => null,
                'prix_unitaire' => 0,
                'categorie_id' => 12,
            ]);

            Stock::firstOrCreate([
                'produit_id' => Produit::where('nom', $nom)->first()->id,
                'quantite_en_stock' => $cannettesStock[$key],

            ]);
        }

        foreach ($sacs as $key => $nom) {

            Produit::firstOrCreate([
                'nom' => $nom,
                'description' => null,
                'image' => null,
                'prix_unitaire' => 0,
                'categorie_id' => 13,
            ]);

            Stock::firstOrCreate([
                'produit_id' => Produit::where('nom', $nom)->first()->id,
                'quantite_en_stock' => $sacsStock[$key],

            ]);
        }
        // Produit::where("nom", $nom)->first()->id ++;
    }
}
