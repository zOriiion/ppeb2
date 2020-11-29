<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Role;
use App\Form\ModifRoleType;

class ModifRoleController extends AbstractController
{
    /**
     * @Route("/modif_role/{id}", name="modif_role", requirements={"id"="\d+"})
     */
    public function modifRole(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoRole = $em->getRepository(Role::class);
        $role = $repoRole->find($id);
        if($role==null){
            $this->addFlash('notice', "Ce role n'existe pas");
            return $this->redirectToRoute('liste_roles');
        }
        $form = $this->createForm(ModifRoleType::class,$role);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request); 
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($role);
                $em->flush();
                $this->addFlash('notice', 'Role modifié');
            }
            return $this->redirectToRoute('liste_roles');
        }
        return $this->render('role/modif_role.html.twig', [
        'form'=>$form->createView()
        ]);
    }
}
