<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Role;
use App\Form\AjoutRoleType;

class RoleController extends AbstractController
{

    /**
     * @Route("/role", name="role")
     */
    public function index(): Response
    {
        return $this->render('role/index.html.twig', [
            'controller_name' => 'RoleController',
        ]);
    }

     /**
    * @Route("/ajout_role", name="ajout_role")
    */
    public function ajoutRole(Request $request)
    {
        $role = new Role(); // Instanciation d’un objet Role
        $form = $this->createForm(AjoutRoleType::class,$role); 
        // Création du formulaire pour ajouter un role, en lui donnant l’instance.
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager(); 
                // On récupère le gestionnaire des entités
                $em->persist($role); // Nous enregistrons notre nouveau role
                $em->flush(); // Nous validons notre ajout
                 $this->addFlash('notice', 'Role inséré'); 
                // Nous préparons le message à afficher à l’utilisateur sur la page où il se rendra
                }
            return $this->redirectToRoute('ajout_role'); 
            // Nous redirigeons l’utilisateur sur l’ajout d’un role après l’insertion.
            }
            return $this->render('role/ajout_role.html.twig', [
            'form'=>$form->createView() // Nous passons le formulaire à la vue
        ]);
    }

    /**
    * @Route("/liste_roles", name="liste_roles")
    */
    public function listeRoles(Request $request)
    {
        $em = $this->getDoctrine();
        $repoRole = $em->getRepository(Role::class);

        if ($request->get('supp')!=null){
            $role = $repoRole->find($request->get('supp'));
            if($role!=null){
                $em->getManager()->remove($role);
                $em->getManager()->flush();
            }
            return $this->redirectToRoute('liste_roles');
        }
           

        $roles = $repoRole->findBy(array(),array('libelle'=>'ASC'));
        
        return $this->render('role/liste_roles.html.twig', [
        'roles'=>$roles // Nous passons la liste des roles à la vue
        ]);
    }
               


}
