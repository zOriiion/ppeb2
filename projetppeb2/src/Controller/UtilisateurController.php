<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Utilisateur;
use App\Entity\Role;
use App\Form\AjoutUtilisateurType;
use App\Form\ImageProfileType;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("/utilisateur", name="utilisateur")
     */
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

     /**
    * @Route("/ajout_utilisateur", name="ajout_utilisateur")
    */
    public function ajoutUtilisateur(Request $request)
    {
        //$role = unRole();
        $utilisateur = new Utilisateur(); // Instanciation d’un objet Utilisateur
        $form = $this->createForm(AjoutUtilisateurType::class,$utilisateur); 
        // Création du formulaire pour ajouter un utilisateur, en lui donnant l’instance.
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); 
                // On récupère le gestionnaire des entités
                $utilisateur->setDateInscription(new \DateTime());
                $em->persist($utilisateur); // Nous enregistrons notre nouvel utilisateur
                $em->flush(); // Nous validons notre ajout
                 $this->addFlash('notice', 'Utilisateur inséré'); 
                // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
                }
            return $this->redirectToRoute('ajout_utilisateur'); 
            // Nous redirigeons l’utilisateur sur l’ajout d’un utilisateur après l’insertion.
            }
            return $this->render('utilisateur/ajout_utilisateur.html.twig', [
            'form'=>$form->createView() // Nous passons le formulaire à la vue
        ]);
    }

    /**
    * @Route("/liste_utilisateurs", name="liste_utilisateurs")
    */
    public function listeUtilisateurs(Request $request)
    {
        $em = $this->getDoctrine();
        $repoUtilisateur = $em->getRepository(Utilisateur::class);
        
        if ($request->get('supp')!=null){
            $utilisateur = $repoUtilisateur->find($request->get('supp'));
            if($utilisateur!=null){
                $em->getManager()->remove($utilisateur);
                $em->getManager()->flush();
            }
            return $this->redirectToRoute('liste_utilisateurs');
        }
                  
        $utilisateurs = $repoUtilisateur->findBy(array(),array('nom'=>'ASC'));
        
        return $this->render('utilisateur/liste_utilisateurs.html.twig', [
        'utilisateurs'=>$utilisateurs // Nous passons la liste des utilisateurs à la vue
        ]);
    }

    /**
     * @Route("/user_profile/{id}", name="user_profile", requirements={"id"="\d+"})
     */
    public function userprofile(int $id, Request $request)
    {
     
        $em = $this->getDoctrine();
        $repoUtilisateur = $em->getRepository(Utilisateur::class);
        $utilisateur = $repoUtilisateur->find($id);
        if ($utilisateur==null){
            $this->addFlash('notice','Utilisateur introuvable');
            return $this->redirectToRoute('accueil');
        }
        $form = $this->createForm(ImageProfileType::class);
        if ($request->isMethod('POST')) {            
            $form->handleRequest($request);            
            if ($form->isSubmitted() && $form->isValid()) {
                $file = $form->get('photo')->getData();
                try{    
                    $fileName = $utilisateur->getId().'.'.$file->guessExtension();
                    $file->move($this->getParameter('profile_directory'),$fileName); // Nous déplaçons lefichier dans le répertoire configuré dans services.yaml
                    $em = $em->getManager();
                    $utilisateur->setPhoto($fileName);
                    $em->persist($utilisateur);
                    $em->flush();
                    $this->addFlash('notice', 'Fichier inséré');

                } catch (FileException $e) {                // erreur durant l’upload            }
                    $this->addFlash('notice', 'Problème fichier inséré');
                }
            }
        }    

        if($utilisateur->getPhoto()==null){
            $path = $this->getParameter('profile_directory').'/anglfran.jpeg';
        }
        else{
            $path = $this->getParameter('profile_directory').'/'.$utilisateur->getPhoto();
        }    
        $data = file_get_contents($path);
        $base64 = 'data:image/png;base64,' . base64_encode($data);

        return $this->render('utilisateur/user_profile.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
            'base64' => $base64
        ]);
    }    


}
