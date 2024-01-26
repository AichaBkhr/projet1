<?php

namespace App\Controller;

use App\Repository\OffresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Offres;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


#[Route('/cart', name:'cart_')]
class CartController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index(SessionInterface $session, OffresRepository $offresRepository)
    {
        $panier = $session->get('panier',[]);
        //intialiser des vars
        $data = [];
        $total = 0;
        foreach ($panier as $id => $quantity) {
            $offre = $offresRepository->find($id);
            $data[] = [
                'offre' => $offre,
                'quantity' => $quantity
            ];
            $total += $offre->getPrix() * $quantity;
        }
        return $this->render('cart/index.html.twig', compact('data', 'total'));
        
    }

    #[Route('/add/{id}', name:'add')]
    #[ParamConverter("offre", class:"App\Entity\Offres")]
    public function add(Offres $offre, SessionInterface $session)
    {
        //récuperer l'id de l'offre 
        $id = $offre->getId();
        //panier existant s'il existe
        $panier = $session->get('panier', []);
        //ajouter le produit dans le panier s'il n'y est pas encore et sinon on incrémente sa quantité.
        if (empty($panier[$id])) {
            $panier[$id]=1;
        }else{
            $panier[$id]++;
        }
        $session->set("panier", $panier);
        //regériger vers la page de panier
        return $this->redirectToRoute('cart_index');
        

    }


    #[Route('/remove/{id}', name:'remove')]
    #[ParamConverter("offre", class:"App\Entity\Offres")]
    public function remove(Offres $offre, SessionInterface $session)
    {
        //récuperer l'id de l'offre 
        $id = $offre->getId();
        //panier existant s'il existe
        $panier = $session->get('panier', []);

        //retirer le produit du panier s'il y en a qu'un seul sion on décremente sa quatité
        //ajouter le produit dans le panier s'il n'y est pas encore et sinon on incrémente sa quantité.
        if (!empty($panier[$id])) {
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }
        $session->set("panier", $panier);
        //regériger vers la page de panier
        return $this->redirectToRoute('cart_index');
        

    }

    #[Route('/delete/{id}', name:'delete')]
    #[ParamConverter("offre", class:"App\Entity\Offres")]
    public function delete(Offres $offre, SessionInterface $session)
    {
        //récuperer l'id de l'offre 
        $id = $offre->getId();
        //panier existant s'il existe
        $panier = $session->get('panier', []);
        //ajouter le produit dans le panier s'il n'y est pas encore et sinon on incrémente sa quantité.
        if (!empty($panier[$id])){
            unset($panier[$id]);
        }
        $session->set("panier", $panier);
        //regériger vers la page de panier
        return $this->redirectToRoute('cart_index');
        

    }

    #[Route('/empty', name:'empty')]
    public function empty(SessionInterface $session)
    {
        $session->remove('panier');
        return $this->redirectToRoute('cart_index');

    }
}