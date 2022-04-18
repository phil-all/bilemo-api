<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 15; $i++) {
            $model = $this->getReference('model_' . $i);

            for ($j = 0; $j < 3; $j++) {
                $product = (new Product())
                    ->setEan13($faker->ean13())
                    ->setStock(rand(80, 7850))
                    ->setColor($this->getReference('color_' . rand(0, 7)))
                    ->setModel($model);

                $manager->persist($product);
            }
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
