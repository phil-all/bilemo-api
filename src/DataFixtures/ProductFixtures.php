<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Service\FakeMobile;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = new FakeMobile();

        for ($i = 1; $i <= 30; $i++) {
            $product = new Product();
            $model   = $faker->fakerModel();

            $product
                ->setModel($model)
                ->setDescription($faker->fakerContent($model))
                ->setPrice($faker->fakerPrice())
                ->setStock($faker->fakerStock());

            // for ($i = 0; $i <= rand(1, 3); $i++) {
            //     $product->addColor($this->getReference('color_' . rand(0, 6)));
            // }

            // for ($i = 0; $i <= rand(4, 7); $i++) {
            //     $product->addHardware($this->getReference('hardware_' . rand(0, 9)));
            // }

            $manager->persist($product);
        }


        $manager->flush();
    }
}
