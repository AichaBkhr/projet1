<?php

namespace App\Controller;

use App\Repository\UtilisateursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profil', name: 'app_profile')]
    public function index(UtilisateursRepository $userRepository): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Récupérer les informations de l'utilisateur
        $userInfo = $userRepository->find($user->getId());

        // Récupérer les commandes de l'utilisateur
        //$userOrders = $user->getCommandes();

        return $this->render('profile/index.html.twig', [
            'user' => $userInfo,
            //'orders' => $userOrders,
        ]);
    }
}

