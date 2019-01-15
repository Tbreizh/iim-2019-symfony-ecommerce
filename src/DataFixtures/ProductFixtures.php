<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Collection;
use Faker\Factory;
use Cocur\Slugify\Slugify;


class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();

        $slugify = new Slugify();
        $repository = $manager->getRepository(Collection::class);
        $collections = $repository->findAll();

        for($i = 0 ; $i< 50; $i++){

            $faker = Factory::create('fr_FR');
            $name = $faker->word;

            $product = new Product();
            $product->setName(ucwords($name));
            $product->setPrice(rand(10 , 100));
            $product->setSku('PRODUCT-' .$i);
            $product->setSLug($slugify->slugify($faker->word));
            $product->setPictureUrl($faker->imageUrl(710, 960, 'cats'));
            $product->setDateAdd(new \DateTime());
            $product->setCollection($collections[rand(0, (count($collections) -1 ))]);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
