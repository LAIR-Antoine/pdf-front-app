<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PriceController extends AbstractController
{
    #[Route('/pricing', name: 'app_price')]
    public function index(): Response
    {
        return $this->render('price/index.html.twig', [
            'controller_name' => 'PriceController',
        ]);
    }
}