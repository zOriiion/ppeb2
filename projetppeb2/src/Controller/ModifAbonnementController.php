<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Abonnement;
use App\Form\ModifAbonnementType;

class ModifAbonnementController extends AbstractController
{
    /**
     * @Route("/modif_abonnement/{id}", name="modif_abonnement", requirements={"id"="\d+"})
     */
    public function modifAbonnement(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoAbonnement = $em->getRepository(Abonnement::class);
        $abonnement = $repoAbonnement->find($id);
        if($abonnement==null){
            $this->addFlash('notice', "Ce thème n'existe pas");
            return $this->redirectToRoute('liste_abonnements');
        }
        $form = $this->createForm(ModifAbonnementType::class,$abonnement);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request); 
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($abonnement);
                $em->flush();
                $this->addFlash('notice', 'Abonnement modifié');
            }
            return $this->redirectToRoute('liste_abonnements');
        }
        return $this->render('abonnement/modif_abonnement.html.twig', [
        'form'=>$form->createView()
        ]);
    }
}
