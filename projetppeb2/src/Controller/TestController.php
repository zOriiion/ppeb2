<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Test;
use App\Entity\Niveau;
use App\Form\AjoutTestType;

class TestController extends AbstractController
{

    /**
     * @Route("/test", name="test")
     */
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

     /**
    * @Route("/ajout_test", name="ajout_test")
    */
    public function ajoutTest(Request $request)
    {
        $test = new Test();
        $form = $this->createForm(AjoutTestType::class,$test); 
        // Création du formulaire pour ajouter un thème, en lui donnant l’instance.
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); 
                // On récupère le gestionnaire des entités
                $em->persist($test); // Nous enregistrons notre nouveau test
                $em->flush(); // Nous validons notre ajout
                 $this->addFlash('notice', 'Test inséré'); 
                // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
                }
            return $this->redirectToRoute('ajout_test'); 
            // Nous redirigeons l’utilisateur sur l’ajout d’un test après l’insertion.
            }
            return $this->render('test/ajout_test.html.twig', [
            'form'=>$form->createView() // Nous passons le formulaire à la vue
        ]);
    }

    /**
    * @Route("/liste_tests", name="liste_tests")
    */
    public function listeTests(Request $request)
    {
        $em = $this->getDoctrine();
        $repoTest = $em->getRepository(Test::class);

        if ($request->get('supp')!=null){
            $test = $repoTest->find($request->get('supp'));
            if($test!=null){
                $em->getManager()->remove($test);
                $em->getManager()->flush();
            }
            return $this->redirectToRoute('liste_tests');
        }
           

        $tests = $repoTest->findBy(array(),array('libelle'=>'ASC'));
        
        return $this->render('test/liste_tests.html.twig', [
        'tests'=>$tests 
        ]);
    }


     /**
    * @Route("/faire_test", name="faire_test")
    */
    public function faireTest(Request $request)
    {
        $test = new Test();
        $form = $this->createForm(AjoutTestType::class,$test); 
        // Création du formulaire pour ajouter un thème, en lui donnant l’instance.
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); 
                // On récupère le gestionnaire des entités
                $em->persist($test); // Nous enregistrons notre nouveau test
                $em->flush(); // Nous validons notre ajout
                 $this->addFlash('notice', 'Test inséré'); 
                // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
                }
            return $this->redirectToRoute('ajout_test'); 
            // Nous redirigeons l’utilisateur sur l’ajout d’un test après l’insertion.
            }
            return $this->render('test/faire_test.html.twig', [
            'form'=>$form->createView() // Nous passons le formulaire à la vue
        ]);
    }
               


}
