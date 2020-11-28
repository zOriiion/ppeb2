<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Vocabulaire;
use App\Form\ModifVocabulaireType;

class ModifVocabulaireController extends AbstractController
{
    /**
     * @Route("/modif_vocabulaire/{id}", name="modif_vocabulaire", requirements={"id"="\d+"})
     */
    public function modifvocabulaire(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoVocabulaire = $em->getRepository(Vocabulaire::class);
        $vocabulaire = $repoVocabulaire->find($id);
        if($vocabulaire==null){
            $this->addFlash('notice', "Ce vocabulaire n'existe pas");
            return $this->redirectToRoute('liste_vocabulaires');
        }
        $form = $this->createForm(ModifVocabulaireType::class,$vocabulaire);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request); 
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($vocabulaire);
                $em->flush();
                $this->addFlash('notice', 'Vocabulaire modifié');
            }
            return $this->redirectToRoute('liste_vocabulaires');
        }
        return $this->render('vocabulaire/modif_vocabulaire.html.twig', [
        'form'=>$form->createView()
        ]);
    }
}
