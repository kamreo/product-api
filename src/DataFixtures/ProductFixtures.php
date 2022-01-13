<?php


namespace App\DataFixtures;


use App\Entity\Product;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture
{
    public const PREFIX = 'product_';

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i <= 20; $i++) {
            $product = new Product();
            $product->setName($faker->name);
            $product->setPrice($faker->randomDigit);
            $product->setQuantity($faker->randomDigit);
            $product->setType($faker->text());
            $this->setReference(self::PREFIX, $product);

            $dateTime = new DateTime('NOW');
            $product->setDateModified($dateTime);
            $product->setDateCreated($dateTime);

            $manager->persist($product);
        }
        $manager->flush();
    }
}