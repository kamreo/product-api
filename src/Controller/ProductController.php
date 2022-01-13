<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    public function getById(string $id, ProductRepository $productRepository): Response{
        $productWithId = $productRepository->findOneBy(['id' => $id]);
        if (!$productWithId) {
            return $this->json('Product with this id doesnt exists!', Response::HTTP_CONFLICT);
        }
        return $this->json(json_encode($productWithId->jsonSerialize()), Response::HTTP_OK);
    }

    public function getAll(ProductRepository $productRepository): Response{
        $products = $productRepository->findAll();
        $productsArray = array();
        foreach($products as $product){
            $productsArray[] = $product->jsonSerialize();
        }
        return $this->json(json_encode($productsArray), Response::HTTP_OK);
    }

    public function create(Request $request, ProductRepository $productRepository, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent());
        $productWithName = $productRepository->findOneBy(['name' => $data->name]);
        if ($productWithName) {
            return $this->json('Product with this name already exists!', Response::HTTP_CONFLICT);
        }
        try {
            $product = new Product();
            $product->setName($data->name);
            $dateTime = new DateTime('NOW');
            $product->setDateCreated($dateTime);
            $product->setDateModified($dateTime);
            $product->setPrice((float)$data->price);
            $product->setQuantity((int)$data->quantity);
            $product->setType($data->type);

            $em->persist($product);
            $em->flush();

        } catch (\Exception $exception) {
            return $this->json('Couldnt create product', Response::HTTP_BAD_REQUEST);
        }
        return $this->json('Created product successfully', Response::HTTP_CREATED);
    }

    public function update(Request $request, ProductRepository $productRepository, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent());
        $productWithId = $productRepository->findOneBy(['id' => $data->id]);
        if (!$productWithId) {
            return $this->json('Product with this id doesnt exist!', Response::HTTP_CONFLICT);
        }
        try {
            $product = new Product();
            $product->setName($data->name ? $data->name : $productWithId->getName());
            $product->setDateCreated($productWithId->getDateCreated());
            $product->setDateModified(new DateTime('NOW'));
            $product->setPrice($data->price ? $data->price : $productWithId->getPrice());
            $product->setQuantity($data->quantity  ? $data->quantity : $productWithId->getQuantity());
            $product->setType($data->type  ? $data->type : $productWithId->getType());

            $em->persist($product);
            $em->flush();

        } catch (\Exception $exception) {
            return $this->json('Couldnt update product', Response::HTTP_BAD_REQUEST);
        }
        return $this->json('Updated product successfully', Response::HTTP_OK);
    }

    public function delete(string $id, ProductRepository $productRepository, EntityManagerInterface $em): Response
    {
        $productWithId = $productRepository->findOneBy(['id' => $id]);
        if (!$productWithId) {
            return $this->json('Product with this id doesnt exist!', Response::HTTP_CONFLICT);
        }
        try {
            $em->remove($productWithId);
            $em->flush();

        } catch (\Exception $exception) {
            return $this->json('Couldnt delete product', Response::HTTP_BAD_REQUEST);
        }
        return $this->json('Updated product successfully', Response::HTTP_OK);
    }
}
