<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\ListeMot;
use App\Form\AjoutListeMotType;

class ListeMotController extends AbstractController
{
    /**
     * @Route("/liste/mot", name="liste_mot")
     */
    public function index(): Response
    {
        return $this->render('liste_mot/index.html.twig', [
            'controller_name' => 'ListeMotController',
        ]);
    }

    /**
    * @Route("/ajout_listemot", name="ajout_listemot")
    */
    public function ajoutListeMot(Request $request)
    {
        $listemot = new ListeMot(); 
        $form = $this->createForm(AjoutListeMotType::class,$listemot); 

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); 
                $em->persist($listemot); 
                $em->flush();
                 $this->addFlash('notice', 'Liste de mots inséré'); 
                }
            return $this->redirectToRoute('ajout_listemot'); 
            }
            return $this->render('liste_mot/ajout_listemot.html.twig', [
            'form'=>$form->createView()
        ]);
    }

}
