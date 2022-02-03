<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class CookieController extends AbstractController
{
    /**
     * @Route("/cookie", name="cookie")
     */
    public function syncCount(Session $session): Response
    {
        $count = count($session->get('panier', []));
        $response = $this->redirectToRoute('panier');
        $cookie = Cookie::create('taillepanier', $count, time() + 3600);
        $response->headers->setCookie($cookie);

        return $response->send();
    }
}
