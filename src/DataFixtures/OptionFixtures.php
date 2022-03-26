<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Option;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * OptionFixtures class
 * @package App\DataFixtures
 */
class OptionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $list = [
            0 => 'wifi',
            1 => 'bluetooth',
            2 => 'GPS',
            3 => 'double optique arrière',
            4 => 'système photo pro',
            5 => 'nano puce',
            6 => 'connectivité 5G',
            7 => 'touch ID',
            8 => 'face ID',
            9 => 'étanche'
        ];

        foreach ($list as $key => $value) {
            $hardware = (new Option())->setOption($value);

            $manager->persist($hardware);

            $this->addReference('option_' . $key, $hardware);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ColorFixtures::class
        ];
    }
}
