<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Entity\DetailsCommandes;
use App\Repository\CommandesRepository;
use App\Repository\OffresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/commandes', name: 'app_orders_')]

class CommandesController extends AbstractController
{

    #[Route('/', name:'index')]
    public function index(CommandesRepository $commandesRepository)
    {
        $commandes = $commandesRepository->findAll(); // Ou une autre méthode pour récupérer les commandes
        return $this->render('commandes/index.html.twig', [
            'commandes' => $commandes,
        ]);
        
    }
    #[Route('/show/{id}', name:'show')]
    #[ParamConverter("commande", class:"App\Entity\Commandes")]
    public function showCommande(Commandes $commande)
    {
        return $this->render('commandes/show.html.twig', [
            'commande' => $commande,
        ]);
        
    }

   
    #[Route('/ajout', name: 'add')]
    public function add(SessionInterface $session, OffresRepository $offresRepository, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $panier = $session->get('panier',[]);

        if ($panier === []) {
            $this->addFlash('message','Votre panier est vide');
            return $this->redirectToRoute('app_main');
        }

        //sinon on crée la commande 
        $order = new Commandes();

        //remplir la commande
        $order->setUtilisateur($this->getUser());
        $order->setReference(uniqid());

        $order->setCle2(strtoupper(bin2hex(random_bytes(3)))); 
        $order->setDateDeCreation(new \DateTimeImmutable()); 
        $order->setQrCode($this->getUser()->getCle1().$order->getCle2());

        //parcourir le panier pour crér les détails des commandes 
        foreach ($panier as $item => $quantity) {
            $orderDetails = new DetailsCommandes();
            //on va cherher l'offre
            $offre = $offresRepository->find($item);
            $price = $offre->getPrix();

            // Mise à jour du nombre de ventes de l'offre
            $nombreDeVentesActuel = $offre->getNombreDeVentes();
            $offre->setNombreDeVentes($nombreDeVentesActuel + $quantity);

            //créer le détail de commande
            $orderDetails->setOffres($offre);
            $orderDetails->setPrix($price);
            $orderDetails->setQuantité($quantity);

            $order->addDetailsCommandes($orderDetails);
        }
        // On persiste et on flush
        $em->persist($order);
        $em->flush();

        $session->remove('panier');

        $commandeId = $order->getId();


        $this->addFlash('message', 'Commande créée avec succès');
        return $this->redirectToRoute("payment", ['id' => $commandeId]);




    }
}
