<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Vocabulaire;
use App\Form\AjoutVocabulaireType;

class VocabulaireController extends AbstractController
{

    /**
     * @Route("/vocabulaire", name="vocabulaire")
     */
    public function index(): Response
    {
        return $this->render('vocabulaire/index.html.twig', [
            'controller_name' => 'VocabulaireController',
        ]);
    }

     /**
    * @Route("/ajout_vocabulaire", name="ajout_vocabulaire")
    */
    public function ajoutVocabulaire(Request $request)
    {
        $vocabulaire = new Vocabulaire(); // Instanciation d’un objet Vocab
        $form = $this->createForm(AjoutVocabulaireType::class,$vocabulaire); 
        // Création du formulaire pour ajouter un vocab, en lui donnant l’instance.
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); 
                // On récupère le gestionnaire des entités
                $em->persist($vocabulaire); // Nous enregistrons notre nouveau vocab
                $em->flush(); // Nous validons notre ajout
                 $this->addFlash('notice', 'Vocabulaire inséré'); 
                // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
                }
            return $this->redirectToRoute('ajout_vocabulaire'); 
            // Nous redirigeons l’utilisateur sur l’ajout d’un vocab après l’insertion.
            }
            return $this->render('vocabulaire/ajout_vocabulaire.html.twig', [
            'form'=>$form->createView() // Nous passons le formulaire à la vue
        ]);
    }

    /**
    * @Route("/liste_vocabulaires", name="liste_vocabulaires")
    */
    public function listeVocabulaires(Request $request)
    {
        $em = $this->getDoctrine();
        $repoVocabulaire = $em->getRepository(Vocabulaire::class);

        if ($request->get('supp')!=null){
            $vocabulaire = $repoVocabulaire->find($request->get('supp'));
            if($vocabulaire!=null){
                $em->getManager()->remove($vocabulaire);
                $em->getManager()->flush();
            }
            return $this->redirectToRoute('liste_vocabulaires');
        }
           

        $vocabulaires = $repoVocabulaire->findBy(array(),array('libelle'=>'ASC'));
        
        return $this->render('vocabulaire/liste_vocabulaires.html.twig', [
        'vocabulaires'=>$vocabulaires // Nous passons la liste du vocabs à la vue
        ]);
    }

}
