<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Utilisateur;
use App\Entity\Role;
use App\Form\AjoutUtilisateurType;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur", name="utilisateur")
     */
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

     /**
    * @Route("/ajout_utilisateur", name="ajout_utilisateur")
    */
    public function ajoutUtilisateur(Request $request)
    {
        //$role = unRole();
        $utilisateur = new Utilisateur(); // Instanciation d’un objet Utilisateur
        $form = $this->createForm(AjoutUtilisateurType::class,$utilisateur); 
        // Création du formulaire pour ajouter un utilisateur, en lui donnant l’instance.
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); 
                // On récupère le gestionnaire des entités
                $utilisateur->setDateInscription(new \DateTime());
                $em->persist($utilisateur); // Nous enregistrons notre nouvel utilisateur
                $em->flush(); // Nous validons notre ajout
                 $this->addFlash('notice', 'Utilisateur inséré'); 
                // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
                }
            return $this->redirectToRoute('ajout_utilisateur'); 
            // Nous redirigeons l’utilisateur sur l’ajout d’un utilisateur après l’insertion.
            }
            return $this->render('utilisateur/ajout_utilisateur.html.twig', [
            'form'=>$form->createView() // Nous passons le formulaire à la vue
        ]);
    }

    /**
    * @Route("/liste_utilisateurs", name="liste_utilisateurs")
    */
    public function listeUtilisateurs(Request $request)
    {
        $em = $this->getDoctrine();
        $repoUtilisateur = $em->getRepository(Utilisateur::class);
        
        if ($request->get('supp')!=null){
            $utilisateur = $repoUtilisateur->find($request->get('supp'));
            if($utilisateur!=null){
                $em->getManager()->remove($utilisateur);
                $em->getManager()->flush();
            }
            return $this->redirectToRoute('liste_utilisateurs');
        }
                  
        $utilisateurs = $repoUtilisateur->findBy(array(),array('nom'=>'ASC'));
        
        return $this->render('utilisateur/liste_utilisateurs.html.twig', [
        'utilisateurs'=>$utilisateurs // Nous passons la liste des utilisateurs à la vue
        ]);
    }


}
