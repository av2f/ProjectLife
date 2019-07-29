<?php

namespace App\DataFixtures;

use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $faker = Faker\Factory::create('fr_FR');
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
