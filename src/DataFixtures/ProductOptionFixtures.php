<?php


namespace App\DataFixtures;


use App\Entity\ProductOption;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductOptionFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i <= 20; $i++) {
            $productOption = new ProductOption();

            $productOption->setName($faker->name);
            $productOption->setPrice($faker->randomDigit);
            $productOption->setQuantity($faker->randomDigit);
            $productOption->setType($faker->text());
            $productOption->setProduct($this->getReference(ProductFixtures::PREFIX));

            $dateTime = new DateTime('NOW');
            $productOption->setDateModified($dateTime);
            $productOption->setDateCreated($dateTime);

            $manager->persist($productOption);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProductFixtures::class,
        ];
    }
}