<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Form\RegistrationFormType;
use App\Security\UsersAuthenticator;
use App\Service\SendMailService;
use App\Service\JWTService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface 
    $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, 
    UsersAuthenticator $authenticator, EntityManagerInterface $entityManager,
    SendMailService $mail, JWTService $jwt): Response //
    {
        $user = new Utilisateurs();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            // Génère une chaîne hexadécimale aléatoire de 3 octets et convertit en majuscules
            $user->setCle1(strtoupper(bin2hex(random_bytes(3)))); 
            $user->setDateDeCreation(new \DateTimeImmutable()); 

            // L'événement prePersist sera déclenché ici pour générer la valeur de cle_1
            //$entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // générer le JWT de l'utilisateur
            // créer le header
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];
            //créer le payload

            $payload = [
                'user_id' => $user->getId()
            ];

            // générer le token

            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

            dd($token);

            // do anything else you need here, like send an email
            $mail->send(
                'no-reply@jeuxolympiques.fr',
                $user->getEmail(),
                'Activation de votre compte sur le site Jeux Olympiques',
                'register',
                compact('user')
            );

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
