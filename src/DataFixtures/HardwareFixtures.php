<?php

namespace App\DataFixtures;

use App\Entity\Hardware;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class HardwareFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $hardwares = [
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

        foreach ($hardwares as $key => $value) {
            $hardware = (new Hardware())->setName($value);

            $manager->persist($hardware);

            $this->addReference('hardware_' . $key, $hardware);
        }

        $manager->flush();
    }
}
