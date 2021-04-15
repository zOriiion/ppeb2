<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Niveau;
use App\Entity\Test;
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
            // Nous redirigeons l’utilisateur sur l’ajout d’un niveau après l’insertion.
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
            $tests = $em->getRepository(Test::class)->findBy(array('idNiveau'=>$niveau));
            if(count($tests)==0){ //S'il n'y a pas de test à ce niveau

                if($niveau!=null){
                    $em->getManager()->remove($niveau);
                    $em->getManager()->flush();
                }
            }else{ //S'il y a des tests à ce niveau
                $this->addFlash('notice','Il existe des tests de ce niveau là, supprimez les avant'); //Message d'erreur s'il y a des tests à ce niveau
            }
            return $this->redirectToRoute('liste_niveaux');
        }
        $niveaux = $repoNiveau->findBy(array(),array('libelle'=>'ASC'));
        
        return $this->render('niveau/liste_niveaux.html.twig', [
        'niveaux'=>$niveaux // Nous passons la liste des niveaux à la vue
        ]);
    }

    //statistiques
    /**
     * @Route("/stats-niveaux", name="stats-niveaux")
     */
    public function statsniveaux(Request $request)
    {

        $em = $this->getDoctrine();
        $repoNiv = $em->getRepository(Niveau::class);


        $conn = $this->getDoctrine()->getManager()->getConnection();


        $sqlListeNiv = '
            SELECT niveau.libelle, COUNT(*) as NbTestParNiv FROM test, niveau WHERE test.id_niveau_id=niveau.id GROUP BY test.id_niveau_id
            ';
        $liste = $conn->prepare($sqlListeNiv);
        $liste->execute(array());

        return $this->render('niveau/stats-niveaux.html.twig', [
            'niveaux' => $liste,
        ]);
    }
               
               


}
