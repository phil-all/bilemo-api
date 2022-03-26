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
    private const SERIES = array('Pro', 'Luxe', 'Orion', 'Xserie', 'Gold', 'Exelium');

    /**
     * @var string
     */
    private string $designation;

    /**
     * @var string
     */
    private string $content;

    /**
     * @var float
     */
    private float $price;

    /**
     * FakeMobile constructor
     */
    public function __construct()
    {
        $this->setDesignation()->setContent()->setPrice();
    }

    /**
     * Get the value of designation
     *
     * @return  string
     */
    public function getDesignation(): string
    {
        return $this->designation;
    }

    /**
     * Get the value of content
     *
     * @return  string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Get the value of price
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Fake mobile designation
     *
     * @return self
     */
    private function setDesignation(): self
    {
        $number = rand(4, 9) . rand(4, 8) . '0 ';

        $this->designation = 'B-' . $number . self::SERIES[rand(0, count(self::SERIES) - 1)];

        return $this;
    }

    /**
     * Fake mobile descrpition
     *
     * @return self
     */
    private function setContent(): self
    {
        $content = [
            0 => 'Le ' . $this->designation . ' est le modèle haut de gamme absolu de la dernière
            série de Bilemo. Tout comme les deux autres modèles de cette nouvelle série, ce
            smartphone supporte le réseau 5G. La 5G vouspermet de surfer sur Internet 30 %
            plus vite qu\'avec la 4G.',
            1 => 'Le ' . $this->designation . ' réinvente la définition de l\'appareil photo : une 
            qualité d\'image professionnelle alliée aux possibilités de communication d\'un
            smartphone. Créez où vous voulez, quand vous voulez.',
            2 => 'Nouveau ' . $this->designation . ' , avec le dernier SoC octa-core Qualcomm Snapdragon
            680 et Game Turbo Écran AMOLED - 6,43 pouces - Résolution FHD+ 1080×2340p -
            Processeur Qualcomm Snapdragon 680 - Octa-core - 4 Go de RAM - 64 Go de ROM.',
            3 => 'Puce a15 bionic pour des performances ultra-rapides. Nouveau processeur
            à 6 cœurs avec 2 cœurs de performance et 4 cœurs d\'efficacité. Nouveau gpu à 4
            cœurs et nouveau moteur neuronal à 16 cœurs. Écran super retina xdr l\'iphone 13
            dispose d\'un écran oled de 6,1 pouces (15,40 cm) de diagonale. Résolution de 2
            532 par 1 170 pixels à 460 p/p. Le mode cinéma ajoute une faible profondeur de 
            champ et déplace automatiquement la mise au point dans les films.',
            4 => 'Le ' . $this->designation . ' dispose d\'une double caméra et d\'un affichage d\'un
            milliard de couleur afin de profiter de chaque détail sur toutes vos photos.
            Capturez le monde comme vous ne l\'avez jamais vu avant. Le' . $this->designation . ' est
            également certifé IP68 contre l\'eau et à la poussière.'
        ];

        $notabulation = preg_replace('/[\s]{12}/', '', $content[rand(0, count($content) - 1)]);

        $this->content = $notabulation;

        return $this;
    }

    /**
     * Fake mobile price
     *
     * @return self
     */
    private function setPrice(): self
    {
        $this->price = floatval(rand(85, 158) . '0');

        return $this;
    }
}
