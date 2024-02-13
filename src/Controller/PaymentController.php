<?php

namespace App\Controller;

use App\Form\PaymentFormType;
use App\Entity\Commandes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    #[Route('/payment/{id}', name:'payment')]
    public function index(Request $request, Commandes $commande): Response
    {
        $form = $this->createForm(PaymentFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Paiement réussi !');
            $commandeId = $commande->getId();
            return $this->redirectToRoute('app_orders_show',['id' => $commandeId] );
    
        }

        return $this->render('payment/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
