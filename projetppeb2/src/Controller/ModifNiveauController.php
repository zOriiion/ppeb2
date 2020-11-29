<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Niveau;
use App\Form\ModifNiveauType;

class ModifNiveauController extends AbstractController
{
    /**
     * @Route("/modif_niveau/{id}", name="modif_niveau", requirements={"id"="\d+"})
     */
    public function modifNiveau(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoNiveau = $em->getRepository(Niveau::class);
        $niveau = $repoNiveau->find($id);
        if($niveau==null){
            $this->addFlash('notice', "Ce thème n'existe pas");
            return $this->redirectToRoute('liste_niveaux');
        }
        $form = $this->createForm(ModifNiveauType::class,$niveau);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request); 
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($niveau);
                $em->flush();
                $this->addFlash('notice', 'Thème modifié');
            }
            return $this->redirectToRoute('liste_niveaux');
        }
        return $this->render('niveau/modif_niveau.html.twig', [
        'form'=>$form->createView()
        ]);
    }
}
