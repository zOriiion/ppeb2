<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Categorie;
use App\Form\ModifCategorieType;

class ModifCategorieController extends AbstractController
{
    /**
     * @Route("/modif_categorie/{id}", name="modif_categorie", requirements={"id"="\d+"})
     */
    public function modifCategorie(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoCategorie = $em->getRepository(Categorie::class);
        $categorie = $repoCategorie->find($id);
        if($categorie==null){
            $this->addFlash('notice', "Ce thème n'existe pas");
            return $this->redirectToRoute('liste_categories');
        }
        $form = $this->createForm(ModifCategorieType::class,$categorie);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request); 
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($categorie);
                $em->flush();
                $this->addFlash('notice', 'Categorie modifié');
            }
            return $this->redirectToRoute('liste_categories');
        }
        return $this->render('categorie/modif_categorie.html.twig', [
        'form'=>$form->createView()
        ]);
    }
}
