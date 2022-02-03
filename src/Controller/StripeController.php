<?php

namespace App\Controller;

use Stripe\Stripe;
use DateTimeImmutable;
use App\Entity\Commande;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use \Stripe\Checkout\Session as StripeSession;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{
    /**
     * @Route("/stripe-create", name="stripecreate")
     */
    public function create(Session $session, EntityManagerInterface $entityManagerInterface, ProductRepository $productRepository): Response
    {

        //on crée une commande constituée de notre panier lorsque l'utilisateur veut payer
        $order = new Commande();
        $order->setCreatedAt(new DateTimeImmutable());
        $order->setState(false);


        $entityManagerInterface->persist($order);
        $entityManagerInterface->flush();

        //$entityManagerInterface->

        $details = $session->get('panier', []);
        $stripecommande = [];

        foreach ($details as $detail) {

            //on enregistre en base de données les détails de produits qu'on avait en panier (session)
            $detail->setAmount($detail->getDetailProduit()->getPrice() * $detail->getQte());
            $detail->setDetailCommande($order);
            $detail->setDetailProduit($productRepository->find($detail->getDetailProduit()->getId()));
            $entityManagerInterface->persist($detail);
            $entityManagerInterface->flush();


            //on crée le tableau de produit a envoyer à stripe
            $stripecommande[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $detail->getDetailProduit()->getName(),
                    ],
                    'unit_amount' => $detail->getDetailProduit()->getPrice() * 100,
                ],
                'quantity' => $detail->getQte(),
            ];
        }

        Stripe::setApiKey($this->getParameter('stripe'));
        $stripesession = StripeSession::create([
            'line_items' => [$stripecommande],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('stripesuccess', [
                'id' => $order->getId()
            ], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('stripefailed', [
                'id' => $order->getId()
            ], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return $this->redirect($stripesession->url);
    }

    /**
     * @Route("/stripe-success/{id}", name="stripesuccess")
     */
    public function success(Commande $commande, Session $session): Response
    {
        $session->remove('panier');
        return $this->render('stripe/index.html.twig', [
            'controller_name' => 'StripeController',
        ]);
    }

    /**
     * @Route("/stripe-failed/{id}", name="stripefailed")
     */
    public function failed(Commande $commande): Response
    {
        return $this->render('stripe/index.html.twig', [
            'controller_name' => 'StripeController',
        ]);
    }
}
