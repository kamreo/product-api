<?php


namespace App\Tests;

use App\Repository\ProductRepository;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Faker\Factory;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends TestCase
{
    public function testCreate()
    {
        $client = new Client(array('verify' => false));
        $faker = Factory::create();

        $data = array(
            'name' => $faker->name,
            'type' => $faker->text(),
            'price' => $faker->randomDigit,
            'quantity' => $faker->randomDigit
        );
        try {
            $response = $client->request('POST', 'https://127.0.0.1:8000/api/product', ['body' => json_encode($data)]);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return $e->getResponse()->getBody()->getContents();
        }

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
    }

    public function testDelete()
    {
        $client = new Client(array('verify' => false));
        $productRepository = $this->createMock(ProductRepository::class);
        $id = $productRepository->getOneRecord()->getId();

        try {
            $response = $client->request('DELETE', 'https://127.0.0.1:8000/api/product/1');
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return $e->getResponse()->getBody()->getContents();
        }

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testFilter()
    {
        $client = new Client(array('verify' => false));

        try {
            $response = $client->request('GET', 'https://127.0.0.1:8000/api/product/?priceTo=20');
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return $e->getResponse()->getBody()->getContents();
        }

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }

    public function testGetById()
    {
        $client = new Client(array('verify' => false));

        try {
            $response = $client->request('GET', 'https://127.0.0.1:8000/api/product/2');
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            return $e->getResponse()->getBody()->getContents();
        }

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}