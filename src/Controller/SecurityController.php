<?php

namespace App\Controller;

use App\Form\ResetPasswordRequestFormType;
use App\Form\ResetPasswordFormType;
use App\Repository\UtilisateursRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/deconnexion', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/oubli-pass', name: 'forgotten_password')]
    public function forgottenPassword(
        Request $request,
        UtilisateursRepository $utilisateursRepository,
        TokenGeneratorInterface $tokenGenerator,
        EntityManagerInterface $entityManager,
        SendMailService $mail
        
        ): Response 
    {
        $form = $this->createForm(ResetPasswordRequestFormType::class);
        
        //traiter ce formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //chercher l'utlisateur par sn email
            $user = $utilisateursRepository->findOneByEmail($form->get('email')->getData());
            
            // vérifier si on a un utilisateur
            if($user){
                //générer un token de réinitialisation
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);
                $entityManager->persist($user);
                $entityManager->flush();

                //générer un lien de réinitialisation de mdps
                $url = $this->generateUrl('reset_pass', ['token'=> $token], UrlGeneratorInterface::ABSOLUTE_URL);
                
                //créer les donnée du mail
                $context = compact('url','user');

                //envoyer le mail
                $mail->send(
                    'no-reply@jeuxolympiques.fr',
                    $user->getEmail(),
                    'Réinitialisation du mot de passe',
                    'password_reset',
                    $context
                );

                $this->addFlash('success','Email envoyé avec succès');
                return $this->redirectToRoute('app_login');
                //$user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));
            }
            // si on a pas d'utilisateur
            $this->addFlash('danger', 'Un problème est survenu !');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/reset_password_request.html.twig', [
            'requestPassForm' => $form->createView()
        ]);
    }

    #[Route(path:'/oubli-pass{token}', name:'reset_pass')]
    public function resetPass(
        string $token,
        Request $request,
        UtilisateursRepository $utilisateursRepository,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
        ): Response
    {
        //vérifier si le token est valid (si on a ce token dans la base de donnée)
        $user = $utilisateursRepository->findOneByResetToken($token);
        if($user){
            $form = $this->createForm(ResetPasswordFormType::class, $user);
            
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // effacer le token
                $user->setResetToken('');
                $user->setPassword(
                    $passwordHasher->hashPassword(
                        $user, 
                        $form->get('password')->getData()
                        )
                );
                $entityManager->persist($user);
                $entityManager->flush();

                $this->addFlash('success','Mot de passe changé avec succès');
                return $this->redirectToRoute('app_login');
            }
            return $this->render('security/reset_password.html.twig', [
                'passForm' => $form->createView()
            ]);
        }
        $this->addFlash('danger','Jeton invalide');
        return $this->redirectToRoute('app_login');

    }
}
