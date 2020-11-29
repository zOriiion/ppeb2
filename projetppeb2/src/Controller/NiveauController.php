<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Niveau;
use App\Form\AjoutNiveauType;

class NiveauController extends AbstractController
{

    /**
     * @Route("/niveau", name="niveau")
     */
    public function index(): Response
    {
        return $this->render('niveau/index.html.twig', [
            'controller_name' => 'NiveauController',
        ]);
    }

     /**
    * @Route("/ajout_niveau", name="ajout_niveau")
    */
    public function ajoutNiveau(Request $request)
    {
        $niveau = new Niveau(); // Instanciation d’un objet Niveau
        $form = $this->createForm(AjoutNiveauType::class,$niveau); 
        // Création du formulaire pour ajouter un thème, en lui donnant l’instance.
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); 
                // On récupère le gestionnaire des entités
                $em->persist($niveau); // Nous enregistrons notre nouveau niveau
                $em->flush(); // Nous validons notre ajout
                 $this->addFlash('notice', 'Niveau inséré'); 
                // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
                }
            return $this->redirectToRoute('ajout_niveau'); 
            // Nous redirigeons l’utilisateur sur l’ajout d’un thème après l’insertion.
            }
            return $this->render('niveau/ajout_niveau.html.twig', [
            'form'=>$form->createView() // Nous passons le formulaire à la vue
        ]);
    }

    /**
    * @Route("/liste_niveaux", name="liste_niveaux")
    */
    public function listeNiveaux(Request $request)
    {
        $em = $this->getDoctrine();
        $repoNiveau = $em->getRepository(Niveau::class);

        if ($request->get('supp')!=null){
            $niveau = $repoNiveau->find($request->get('supp'));
            if($niveau!=null){
                $em->getManager()->remove($niveau);
                $em->getManager()->flush();
            }
            return $this->redirectToRoute('liste_niveaux');
        }
           

        $niveaux = $repoNiveau->findBy(array(),array('libelle'=>'ASC'));
        
        return $this->render('niveau/liste_niveaux.html.twig', [
        'niveaux'=>$niveaux // Nous passons la liste des niveaux à la vue
        ]);
    }
               


}