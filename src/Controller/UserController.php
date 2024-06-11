<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
/*     #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    } */

    #[Route('/signup', name: 'app_signup')]
    public function signup(): Response
    {
        return $this->render('user/signup.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/signin', name: 'app_signin')]
    public function signin(): Response
    {
        return $this->render('user/signin.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    
}
