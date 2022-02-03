<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Session\Session;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProductRepository $productRepository, Session $session): Response
    {
        $produits = $productRepository->findAll();
        return $this->render('home/index.html.twig', [
            'products' => $produits,
        ]);
    }

    /**
     * @Route("/hello", name="hello")
     */
    public function hello(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Function HELLO',
        ]);
    }
}
