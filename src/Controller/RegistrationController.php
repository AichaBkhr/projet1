<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Form\RegistrationFormType;
use App\Security\UsersAuthenticator;
use App\Service\SendMailService;
use App\Service\JWTService;
use App\Controller\JWTSrvice;
use App\Repository\UtilisateursRepository;
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

            

            // do anything else you need here, like send an email
            $mail->send(
                'no-reply@jeuxolympiques.fr',
                $user->getEmail(),
                'Activation de votre compte sur le site Jeux Olympiques',
                'register',
                compact('user', 'token')
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

    // créer une nouvelle route pour vérifier l'utilisateur 
    #[Route('/verif/{token}', name: 'verify_user')]
    public function verifyUser($token, JWTService $jwt,
     UtilisateursRepository $usersRepository, EntityManagerInterface $em): Response
    {
        // vérifier si le token est valide, n'a pas expiré et n'a pas été modifié !
        if($jwt->isValid($token) && !$jwt->isExpired($token) &&
        $jwt->check($token, $this->getParameter('app.jwtsecret') )){
            // on récupere le paayload
            $payload = $jwt->getPayload($token);

            //écuperer le user du token
            $user = $usersRepository->find($payload['user_id']);

            // vérifier si l'ytilisateur existe et n'a pas encore activé son compte
            if( $user && !$user->getIsVerified()){
                $user->setIsVerified(true);
                $em->flush($user);
                $this->addFlash('success', 'Compte utilisateur activé !');
                return $this->redirectToRoute('app_profile');

            }

        }
        // en cas de problème 
        $this->addFlash('danger', 'Le token est invalide ou a expiré');
        return $this->redirectToRoute('app_main');
    }

    #[Route('/renvoiverif', name: 'resend_verif')]
    public function resendVerif(JWTService $jwt, SendMailService
    $mail, UtilisateursRepository $usersRepository): Response
    {
        $user = $this->getUser();

        if(!$user){
            $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }
        if($user->getIsVerified()){
            $this->addFlash('warning', 'Cet utilisateur est déjà activé !');
            return $this->redirectToRoute('app_profile');
        }
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

        // send an email
        $mail->send(
            'no-reply@jeuxolympiques.fr',
            $user->getEmail(),
            'Activation de votre compte sur le site Jeux Olympiques',
            'register',
            compact('user', 'token')
        );
        $this->addFlash('success', 'Email de vérification envoyé !');
        return $this->redirectToRoute('app_profile');
    
    }
}
