<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Categorie;
use App\Form\AjoutCategorieType;

class CategorieController extends AbstractController
{

    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

     /**
    * @Route("/ajout_categorie", name="ajout_categorie")
    */
    public function ajoutCategorie(Request $request)
    {
        $categorie = new Categorie(); 
        $form = $this->createForm(AjoutCategorieType::class,$categorie); 

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); 
                // On récupère le gestionnaire des entités
                $em->persist($categorie); 
                $em->flush(); // Nous validons notre ajout
                 $this->addFlash('notice', 'Categorie inséré'); 
                // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
                }
            return $this->redirectToRoute('ajout_categorie'); 
            // Nous redirigeons l’utilisateur sur l’ajout d’un thème après l’insertion.
            }
            return $this->render('categorie/ajout_categorie.html.twig', [
            'form'=>$form->createView() // Nous passons le formulaire à la vue
        ]);
    }

    /**
    * @Route("/liste_categories", name="liste_categories")
    */
    public function listeCategories(Request $request)
    {
        $em = $this->getDoctrine();
        $repoCategorie = $em->getRepository(Categorie::class);

        if ($request->get('supp')!=null){
            $categorie = $repoCategorie->find($request->get('supp'));
            if($categorie!=null){
                $em->getManager()->remove($categorie);
                $em->getManager()->flush();
            }
            return $this->redirectToRoute('liste_categories');
        }
           

        $categories = $repoCategorie->findBy(array(),array('libelle'=>'ASC'));
        
        return $this->render('categorie/liste_categories.html.twig', [
        'categories'=>$categories
        ]);
    }

    /**
     * @Route("/stats-categories", name="stats-categories")
     */
    public function statscategories(Request $request)
    {
        // LA BASE

        $em = $this->getDoctrine();
        $repoEnt = $em->getRepository(Categorie::class);

        // ON ETABLI LA CONNEXION

        $conn = $this->getDoctrine()->getManager()->getConnection();

        // POUR LA LISTE AVEC ID, LIBELLE, etc

        $sqlListeEnt = '
            SELECT e.libelle, COUNT(*) as NbParEnt FROM vocabulaire v, categorie c WHERE v.categorie_id=c.id GROUP BY v.categorie_id
            ';
        $liste = $conn->prepare($sqlListeEnt);
        $liste->execute(array());



        // POUR LE RENDER
        // Nous passons la liste des entreprises + le count à la vue

        return $this->render('categorie/stats-categories.html.twig', [
            'categories' => $liste, //ICI C'EST AVEC L'ID ET LE LIBELLE
        ]);
    }
               


}
