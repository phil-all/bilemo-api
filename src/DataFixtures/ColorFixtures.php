<?php

namespace App\DataFixtures;

use App\Entity\Color;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ColorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $colors = [
            0 => 'antracite',
            1 => 'gris sombre',
            2 => 'gris clair',
            3 => 'or',
            4 => 'cuivre',
            5 => 'blanc',
            6 => 'argent'
        ];

        foreach ($colors as $key => $value) {
            $color = (new Color())->setName($value);

            $manager->persist($color);

            $this->addReference('color_' . $key, $color);
        }

        $manager->flush();
    }
}
