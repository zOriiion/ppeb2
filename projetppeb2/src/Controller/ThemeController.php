<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Theme;
use App\Form\AjoutThemeType;

class ThemeController extends AbstractController
{

    /**
     * @Route("/theme", name="theme")
     */
    public function index(): Response
    {
        return $this->render('theme/index.html.twig', [
            'controller_name' => 'ThemeController',
        ]);
    }

     /**
    * @Route("/ajout_theme", name="ajout_theme")
    */
    public function ajoutTheme(Request $request)
    {
        $theme = new Theme(); // Instanciation d’un objet Theme
        $form = $this->createForm(AjoutThemeType::class,$theme); 
        // Création du formulaire pour ajouter un thème, en lui donnant l’instance.
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); 
                // On récupère le gestionnaire des entités
                $em->persist($theme); // Nous enregistrons notre nouveau thème
                $em->flush(); // Nous validons notre ajout
                 $this->addFlash('notice', 'Thème inséré'); 
                // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
                }
            return $this->redirectToRoute('ajout_theme'); 
            // Nous redirigeons l’utilisateur sur l’ajout d’un thème après l’insertion.
            }
            return $this->render('theme/ajout_theme.html.twig', [
            'form'=>$form->createView() // Nous passons le formulaire à la vue
        ]);
    }

    /**
    * @Route("/liste_themes", name="liste_themes")
    */
    public function listeThemes(Request $request)
    {
        $em = $this->getDoctrine();
        $repoTheme = $em->getRepository(Theme::class);

        if ($request->get('supp')!=null){
            $theme = $repoTheme->find($request->get('supp'));
            if($theme!=null){
                $em->getManager()->remove($theme);
                $em->getManager()->flush();
            }
            return $this->redirectToRoute('liste_themes');
        }
           

        $themes = $repoTheme->findBy(array(),array('libelle'=>'ASC'));
        
        return $this->render('theme/liste_themes.html.twig', [
        'themes'=>$themes // Nous passons la liste des thèmes à la vue
        ]);
    }
               


}
