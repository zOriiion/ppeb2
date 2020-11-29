<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Abonnement;
use App\Form\AjoutAbonnementType;

class AbonnementController extends AbstractController
{

    /**
     * @Route("/abonnement", name="abonnement")
     */
    public function index(): Response
    {
        return $this->render('abonnement/index.html.twig', [
            'controller_name' => 'AbonnementController',
        ]);
    }

     /**
    * @Route("/ajout_abonnement", name="ajout_abonnement")
    */
    public function ajoutAbonnement(Request $request)
    {
        $abonnement = new Abonnement(); 
        $form = $this->createForm(AjoutAbonnementType::class,$abonnement); 
        
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); 
                // On récupère le gestionnaire des entités
                $em->persist($abonnement);
                $em->flush(); // Nous validons notre ajout
                 $this->addFlash('notice', 'Abonnement inséré'); 
                // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
                }
            return $this->redirectToRoute('ajout_abonnement'); 
            
        
            }
            return $this->render('abonnement/ajout_abonnement.html.twig', [
            'form'=>$form->createView() // Nous passons le formulaire à la vue
        ]);
    }

    /**
    * @Route("/liste_abonnements", name="liste_abonnements")
    */
    public function listeAbonnements(Request $request)
    {
        $em = $this->getDoctrine();
        $repoAbonnement = $em->getRepository(Abonnement::class);

        if ($request->get('supp')!=null){
            $abonnement = $repoAbonnement->find($request->get('supp'));
            if($abonnement!=null){
                $em->getManager()->remove($abonnement);
                $em->getManager()->flush();
            }
            return $this->redirectToRoute('liste_abonnements');
        }
           

        $abonnements = $repoAbonnement->findBy(array(),array('libelle'=>'ASC'));
        
        return $this->render('abonnement/liste_abonnements.html.twig', [
        'abonnements'=>$abonnements 
        ]);
    }
               


}
