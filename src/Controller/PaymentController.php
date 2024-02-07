<?php

namespace App\Controller;

use App\Form\PaymentFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payment", name="payment")
     */
    #[Route('/payment', name:'payment')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(PaymentFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Paiement réussi !');
            return $this->redirectToRoute('payment');
        }

        return $this->render('payment/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
