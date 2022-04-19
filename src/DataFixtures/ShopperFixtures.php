<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Shopper;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ShopperFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 500; $i++) {
            $shopper = (new Shopper())
                ->setEmail($faker->email())
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setClient($this->getReference(('client_' . rand(0, 2))));

            $manager->persist($shopper);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ClientFixtures::class
        ];
    }
}
