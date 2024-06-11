<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Subscription;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{

    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'controller_name' => 'SecurityController',
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        //nothing here
    }

    #[Route('/signup', name: 'app_signup', methods: ['GET', 'POST'])]
    public function registration(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $email = $form->get('email')->getData();

            $existingUser = $manager->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($existingUser) {
                $this->addFlash(
                    'error',
                    'Email already exists.'
                );
                return $this->render('user/signup.html.twig', [
                    'form' => $form->createView()
                ]);
            }

            if ($form->isValid()) {
                $user = $form->getData();

                if ($user->getPlainPassword() !== $form->get('plainPassword')->getData()) {
                    $this->addFlash(
                        'error',
                        'Les deux mots de passe ne correspondent pas.'
                    );
                    return $this->render('user/signup.html.twig', [
                        'form' => $form->createView()
                    ]);
                }

                $hashedPassword = $passwordHasher->hashPassword($user, $user->getPlainPassword());
                $user->setPassword($hashedPassword);
                $user->setCreatedAt(new \DateTimeImmutable(null, new \DateTimeZone('Europe/Paris')));
                $user->setUpdatedAt(new \DateTimeImmutable(null, new \DateTimeZone('Europe/Paris')));
                $this->addFlash(
                    'success',
                    'Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.'
                );

                $freeSubscription = $manager->getRepository(Subscription::class)->findOneBy(['title' => 'Gratuit']);

                $user->setSubscription($freeSubscription);

                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('user/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }
}