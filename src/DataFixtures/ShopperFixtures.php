<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use DateTimeImmutable;
use App\Entity\Shopper;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ShopperFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 500; $i++) {
            /** @var DateTime */
            $date = $faker->dateTimeBetween('-29 day', 'now', 'Europe/Paris');

            $shopper = new Shopper();

            $shopper
                ->setFirstName($faker->firstName())
                ->setLastName($faker->lastName())
                ->setEmail($faker->email())
                ->setClient($this->getReference('client_' . rand(0, 2)))
                ->setCreatedAt(DateTimeImmutable::createFromMutable($date));

            $manager->persist($shopper);
        }

        $manager->flush();
    }
}
