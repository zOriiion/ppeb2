<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Utilisateur;
use App\Form\ModifUtilisateurType;

class ModifUtilisateurController extends AbstractController
{
    /**
 * @Route("/modif_utilisateur/{id}", name="modif_utilisateur", requirements={"id"="\d+"})
 */
 public function modifUtilisateur(int $id, Request $request)
 {
    $em = $this->getDoctrine();
    $repoUtilisateur = $em->getRepository(Utilisateur::class);
    $utilisateur = $repoUtilisateur->find($id);
    if($utilisateur==null){
        $this->addFlash('notice', "Cet utilisateur n'existe pas");
        return $this->redirectToRoute('liste_utilisateurs');
    }
    $form = $this->createForm(ModifUtilisateurType::class,$utilisateur);
    if ($request->isMethod('POST')) {
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();
            $this->addFlash('notice', 'Utilisateur modifié');
        }
        return $this->redirectToRoute('liste_utilisateurs');
    }
    return $this->render('utilisateur/modif_utilisateur.html.twig', [
    'form'=>$form->createView()
    ]);
    }
   
}
