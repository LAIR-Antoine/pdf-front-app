<?php

namespace App\Controller;

use App\Entity\Subscription;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class PriceController extends AbstractController
{
    #[Route('/pricing', name: 'app_price')]
    public function index(): Response
    {
        $user = $this->getUser();
        $subscription = $user->getSubscription();

        $subscriptionId = $subscription->getId();

        return $this->render('price/index.html.twig', [
            'controller_name' => 'PriceController',
            'subscription' => $subscriptionId,
        ]);
    }

    #[Route('/pricing/change-offer', name: 'app_change_offer', methods: ['GET'])]
    public function changeOffer(Request $request, EntityManagerInterface $manager): Response
    {

        $offerId = $request->query->get('offer_id');

        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();
        $subscription = $user->getSubscription();

        $newSubscription = $manager->getRepository(Subscription::class)->findOneBy(['id' => $offerId]);
        $user->setSubscription($newSubscription);
        $user->setSubscriptionEndAt(new \DateTimeImmutable('+1 month'));
        $manager->persist($user);
        $manager->flush();

        return $this->redirectToRoute('app_price');

    }
}
