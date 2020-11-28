<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Theme;
use App\Form\ModifThemeType;

class ModifThemeController extends AbstractController
{
    /**
     * @Route("/modif_theme/{id}", name="modif_theme", requirements={"id"="\d+"})
     */
    public function modifTheme(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoTheme = $em->getRepository(Theme::class);
        $theme = $repoTheme->find($id);
        if($theme==null){
            $this->addFlash('notice', "Ce thème n'existe pas");
            return $this->redirectToRoute('liste_themes');
        }
        $form = $this->createForm(ModifThemeType::class,$theme);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request); 
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($theme);
                $em->flush();
                $this->addFlash('notice', 'Thème modifié');
            }
            return $this->redirectToRoute('liste_themes');
        }
        return $this->render('theme/modif_theme.html.twig', [
        'form'=>$form->createView()
        ]);
    }
}
