<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Collection;
use Faker\Factory;
use Cocur\Slugify\Slugify;

class CollectionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();

        $slugify = new Slugify();

        for($i = 0 ; $i< 5; $i++){

            $faker = Factory::create('fr_FR');
            $name = $faker->word;

            $collection = new Collection();
            $collection->setName(ucwords($name));
            $collection->setSLug($slugify->slugify($faker->word));
            $collection->setPictureUrl($faker->imageUrl(1920, 570, 'cats'));
            $collection->setDateAdd(new \DateTime());
            $manager->persist($collection);
        }

        $manager->flush();
    }
}
