<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Client;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $hasher;

    /**
     * OwnerFixtures constructor
     *
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('en_US');

        for ($i = 0; $i < 3; $i++) {
            $client = new Client();

            $client
                ->setEmail($faker->companyEmail())
                ->setRoles(['ROLE_CLIENT'])
                ->setPassword($this->hasher->hashPassword($client, 'pass1234'))
                ->setCompany($faker->lastName() . ' ' . $faker->companySuffix())
                ->setDiscountRate($faker->randomFloat(2, 1, 20));

            $manager->persist($client);

            $this->addReference('client_' . $i, $client);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ModelFixtures::class
        ];
    }
}
