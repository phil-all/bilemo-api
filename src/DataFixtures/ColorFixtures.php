<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Color;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * ClorFixtures class
 * @package App\dataFixtures
 */
class ColorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr, FR');

        for ($i = 0; $i < 8; $i++) {
            $color = (new Color())->setColor($faker->safeColorName());

            $manager->persist($color);

            $this->addReference('color_' . $i, $color);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SizeFixtures::class
        ];
    }
}
