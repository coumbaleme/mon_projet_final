<?php
namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailProductController extends AbstractController
{
    #[Route('/product/{id}', name: 'product_detail', requirements: ['id' => '\d+'])]
    public function index(Product $product): Response
    {
        return $this->render('detail_product/index.html.twig', [
            'product' => $product,
        ]);
    }
}