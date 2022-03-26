<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Model;
use App\Service\FakeMobile;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * ModelFixtures class
 * @package App\DataFixtures
 */
class ModelFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 15; $i++) {
            $faker = new FakeMobile();
            $rand = Factory::create();

            $model = (new Model())
                ->setDesignation($faker->getDesignation())
                ->setDescription($faker->getContent())
                ->setPrice($faker->getPrice())
                ->setSize($this->getReference('size_' . rand(0, 3)));

            for ($j = 4; $j < 10; $j++) {
                $model->addOption($this->getReference('option_' . $rand->randomDigit()));
            }

            $manager->persist($model);

            $this->addReference('model_' . $i, $model);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            OptionFixtures::class
        ];
    }
}
