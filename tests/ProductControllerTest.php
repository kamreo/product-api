<?php


namespace App\Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Faker\Factory;

class ProductControllerTest extends TestCase
{
    public function testPOST()
    {
        $client = new Client(array('verify' => false));
        $faker = Factory::create();

        $data = array(
            'name' => $faker->name,
            'type' => $faker->text(),
            'price' => $faker->randomDigit
        );

        $response = $client->request('POST', 'http://localhost:8000/api/product', $data);

    }
}