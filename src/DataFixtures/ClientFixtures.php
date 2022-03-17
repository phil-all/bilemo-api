<?php

namespace App\DataFixtures;

use DateTime;
use Faker\Factory;
use App\Entity\Client;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture
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
        $list  = [];

        for ($i = 0; $i < 3; $i++) {
            $list[$i] = $faker->lastName() . ' ' . $faker->companySuffix();
        }

        for ($j = 0; $j < count($list); $j++) {
            /** @var DateTime */
            $date = $faker->dateTimeBetween('-60 day', '-30 day', 'Europe/Paris');

            $client = new Client();

            $client
                ->setUsername($list[$j])
                ->setRoles(['ROLE_API_CLIENT'])
                ->setPassword($this->hasher->hashPassword($client, 'pass1234'))
                ->setCreatedAt(DateTimeImmutable::createFromMutable($date));

            $manager->persist($client);

            $this->addReference('client_' . $j, $client);
        }

        $manager->flush();
    }
}
