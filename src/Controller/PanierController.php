<?php

namespace App\Controller;

use App\Entity\Detail;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function panier(Session $session): Response
    {
        $details = $session->get('panier', []);
        return $this->render('panier/index.html.twig', [
            'details' => $details,
        ]);
    }

    /**
     * @Route("/panier-new/{id}", name="addpanier")
     */
    public function add(Product $product, Session $session): Response
    {
        $details = $session->get('panier', []);

        foreach ($details as $det) {
            if ($det->getDetailProduit()->getId() == $product->getId()) {
                return $this->redirectToRoute('panier');
            }
        }

        $detail = new Detail();
        $detail->setQte(1);
        $detail->setDetailProduit($product);

        $details[] = $detail;
        $session->set('panier', $details);
        return $this->redirectToRoute('cookie');
    }

    /**
     * @Route("/panier-remove/{id}", name="removecart")
     */
    public function remove(Product $product, Session $session): Response
    {
        $details = $session->get('panier', []);
        foreach ($details as $key => $det) {
            if ($det->getDetailProduit()->getId() == $product->getId()) {
                unset($details[$key]);
            }
        }

        $session->set('panier', $details);
        return $this->redirectToRoute('cookie');
    }
}
