<?php

namespace App\DataFixtures;

use App\Entity\Size;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * SizeFixtures class
 * @package App\DataFixtures;
 */
class SizeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $list = array(6.4, 6.58, 7.3, 7.6);

        foreach ($list as $key => $value) {
            $size = (new Size())->setSize($value);

            $manager->persist($size);

            $this->addReference('size_' . $key, $size);
        }

        $manager->flush();
    }
}
