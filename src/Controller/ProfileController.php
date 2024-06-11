<?php

namespace App\Controller;

use App\Entity\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(EntityManagerInterface $manager): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        
        $user = $this->getUser();
        $subscription = $user->getSubscription();
        $pdfs = $manager->getRepository(Pdf::class)->findBy(['user' => $user]);

        foreach ($pdfs as $pdf) {
            $pdf->getTitle();
            $pdf->getCreatedAt();
        }

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'user' => $user,
            'subscription' => $subscription,
            'pdfs' => $pdfs
        ]);
    }
}
