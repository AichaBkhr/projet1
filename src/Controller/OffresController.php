<?php

namespace App\Controller;

use App\Repository\OffresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffresController extends AbstractController
{
    #[Route('/offres', name: 'app_offres')]
    public function index( OffresRepository $offresRepository): Response
    {
        return $this->render('offres/index.html.twig', [
            'offres' => $offresRepository->findBy([],['capacité' => 'asc'])
        ]);
    }
}
