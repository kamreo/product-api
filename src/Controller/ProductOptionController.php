<?php


namespace App\Controller;


use App\Entity\Product;
use App\Entity\ProductOption;
use App\Repository\ProductOptionRepository;
use App\Repository\ProductRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductOptionController extends AbstractController
{
    public function create(Request $request, ProductOptionRepository $productOptionRepository, ProductRepository $productRepository, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent());
        $productOptionWithName = $productOptionRepository->findOneBy(['name' => $data->name]);
        $productWithId = $productRepository->findOneBy(['id' => $data->parentId]);

        if ($productOptionWithName) {
            return $this->json('Product with this name already exists!', Response::HTTP_CONFLICT);
        }
        if (!$productWithId) {
            return $this->json('Product family with this id doesnt exist!', Response::HTTP_CONFLICT);
        }
        try {
            $product = new ProductOption();
            $product->setName($data->name);
            $dateTime = new DateTime('NOW');
            $product->setDateCreated($dateTime);
            $product->setDateModified($dateTime);
            $product->setPrice((float)$data->price);
            $product->setQuantity((int)$data->quantity);
            $product->setType($productWithId->getType());

            $em->persist($product);
            $em->flush();

        } catch (\Exception $exception) {
            return $this->json('Couldnt create product', Response::HTTP_BAD_REQUEST);
        }
        return $this->json('Created product successfully', Response::HTTP_CREATED);
    }
}