<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Test;
use App\Form\ModifTestType;

class ModifTestController extends AbstractController
{
    /**
     * @Route("/modif_test/{id}", name="modif_test", requirements={"id"="\d+"})
     */
    public function modifTest(int $id, Request $request)
    {
        $em = $this->getDoctrine();
        $repoTest = $em->getRepository(Test::class);
        $test = $repoTest->find($id);
        if($test==null){
            $this->addFlash('notice', "Ce test n'existe pas");
            return $this->redirectToRoute('liste_tests');
        }
        $form = $this->createForm(ModifTestType::class,$test);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request); 
            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($test);
                $em->flush();
                $this->addFlash('notice', 'Thème modifié');
            }
            return $this->redirectToRoute('liste_tests');
        }
        return $this->render('test/modif_test.html.twig', [
        'form'=>$form->createView()
        ]);
    }
}
