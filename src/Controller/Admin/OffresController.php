<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Offres;
use App\Form\OffresFormType;
use App\Repository\OffresRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


#[Route('/admin/offres', name: 'admin_offres_')]
class OffresController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(OffresRepository $offresRepository): Response
    {
        $offres = $offresRepository->findAll(); 
        return $this->render('admin/offres/index.html.twig', compact('offres'));
    }

    #[Route('/ajout', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {   
        //créer une nvlle offre
        $offre = new Offres();

        // créer le formulaire
        $offreForm = $this->createForm(OffresFormType::class, $offre);
        
        // traiter le formulaire
        $offreForm->handleRequest($request);

        //vérifier si le formulaire est soumis et valide 
        if ($offreForm->isSubmitted() && $offreForm->isValid()) {
            $em->persist($offre);   
            $em->flush();
            $this->addFlash('success','L\'offre a été ajouté avec succès');
            return $this->redirectToRoute('admin_offres_index');
        }    

        return $this->render('admin/offres/add.html.twig', [
            'offreForm'=> $offreForm->createView()
        ]);
    }


    #[Route('/edition/{id}', name: 'edit')]
    #[ParamConverter("offre", class:"App\Entity\Offres")]
    public function edit(Offres $offre, Request $request, EntityManagerInterface $em): Response
    {
        // créer le formulaire
        $offreForm = $this->createForm(OffresFormType::class, $offre);
        if (!$offre) {
            // Gérer le cas où l'entité n'est pas trouvée
            throw $this->createNotFoundException('L\'offre n\'existe pas');
        }
        
        // traiter le formulaire
        $offreForm->handleRequest($request);

        //vérifier si le formulaire est soumis et valide 
        if ($offreForm->isSubmitted() && $offreForm->isValid()) {
            // Vous n'avez pas besoin de persist car l'entité est automatiquement gérée par Symfony
            $em->flush();
            
            $this->addFlash('success', 'L\'offre a été modifiée avec succès');
            return $this->redirectToRoute('admin_offres_index');
        }    

        return $this->render('admin/offres/edit.html.twig', [
            'offreForm' => $offreForm->createView(),
        ]);
    }


    //refaire !!!
    #[Route('/suppression/{id}', name: 'delete')]
    #[ParamConverter("offre", class:"App\Entity\Offres")]
    public function delete(Offres $offre, EntityManagerInterface $em): Response
    {
        if (!$offre) {
            // Gérer le cas où l'entité n'est pas trouvée
            throw $this->createNotFoundException('L\'offre n\'existe pas');
        }

        // Supprimer l'entité de la base de données
        $em->remove($offre);
        $em->flush();

        $this->addFlash('success', 'L\'offre a été supprimée avec succès');
        
        // Rediriger vers la liste des offres après la suppression
        return $this->redirectToRoute('admin_offres_index');
    }

}