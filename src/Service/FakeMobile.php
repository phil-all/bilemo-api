<?php

namespace App\Service;

use Faker\Factory as Build;
use Faker\Generator as Fake;

/**
 * FakeMobile, used for data fixtures
 * @package  App\Service
 */
class FakeMobile
{
    private Fake $fake;

    public function __construct()
    {
        $this->fake = Build::create();
    }

    /**
     * Fake mobile stock
     *
     * @return integer
     */
    public function fakerStock(): int
    {
        return rand(230, 5200);
    }

    /**
     * Fake mobile model
     *
     * @return string
     */
    public function fakerModel(): string
    {
        $series = [
            0 => 'Pro',
            1 => 'Luxe',
            2 => 'Orion',
            3 => 'Xserie',
            4 => 'Gold',
            5 => 'Exelium'
        ];

        return 'B-' . $this->fake->regexify('[4-9]{1}[4-8]{1}0 ') . $series[rand(0, 5)];
    }

    /**
     * Fake mobile price
     *
     * @return float
     */
    public function fakerPrice(): float
    {
        return floatval(rand(85, 158) . '0');
    }

    /**
     * Fake mobile descrpition
     *
     * @param string $model
     *
     * @return string
     */
    public function fakerContent(string $model): string
    {
        $content = [
            0 => 'Le ' . $model . ' est le modèle haut de gamme absolu de la dernière
            série de Bilemo. Tout comme les deux autres modèles de cette nouvelle série, ce
            smartphone supporte le réseau 5G. La 5G vouspermet de surfer sur Internet 30 %
            plus vite qu\'avec la 4G.',
            1 => 'Le ' . $model . ' réinvente la définition de l\'appareil photo : une 
            qualité d\'image professionnelle alliée aux possibilités de communication d\'un
            smartphone. Créez où vous voulez, quand vous voulez.',
            2 => 'Nouveau ' . $model . ' , avec le dernier SoC octa-core Qualcomm Snapdragon
            680 et Game Turbo Écran AMOLED - 6,43 pouces - Résolution FHD+ 1080×2340p -
            Processeur Qualcomm Snapdragon 680 - Octa-core - 4 Go de RAM - 64 Go de ROM.',
            3 => 'Puce a15 bionic pour des performances ultra-rapides. Nouveau processeur
            à 6 cœurs avec 2 cœurs de performance et 4 cœurs d\'efficacité. Nouveau gpu à 4
            cœurs et nouveau moteur neuronal à 16 cœurs. Écran super retina xdr l\'iphone 13
            dispose d\'un écran oled de 6,1 pouces (15,40 cm) de diagonale. Résolution de 2
            532 par 1 170 pixels à 460 p/p. Le mode cinéma ajoute une faible profondeur de 
            champ et déplace automatiquement la mise au point dans les films.',
            4 => 'Le ' . $model . ' dispose d\'une double caméra et d\'un affichage d\'un
            milliard de couleur afin de profiter de chaque détail sur toutes vos photos.
            Capturez le monde comme vous ne l\'avez jamais vu avant. Le' . $model . ' est
            également certifé IP68 contre l\'eau et à la poussière.'
        ];

        $notabulation = preg_replace('/[\s]{12}/', '-', $content[rand(0, 2)]);

        return $notabulation;
    }
}
