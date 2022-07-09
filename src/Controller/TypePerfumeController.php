<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\TypePerfumeType;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\TypePerfume;
class TypePerfumeController extends AbstractController
{
    /**
     * @Route("/type/perfume", name="app_type_perfume")
     */
    // public function index(): Response
    // {
    //     return $this->render('type_perfume/index.html.twig', [
    //         'controller_name' => 'TypePerfumeController',
    //     ]);
    // }
    /**
     * @Route("typePerfume",name="typePerfume_user")
     */
    public function indexActionUser()
    {
        
        $em = $this->getDoctrine()->getManager();

        $typePerfumes = $em->getRepository(TypePerfume::class)->findAll();

        return $this->render('type_perfume/index.html.twig', array(
            'typePerfumes' => $typePerfumes,
        ));
    }
    /**
 * @Route("/typePerfume/details/{id}", name="typePerfume_details")
 */
public
function detailsAction($id)
{
    
    $em = $this->getDoctrine()->getManager();

    $typePerfumes = $em->getRepository(TypePerfume::class)->find($id);

    return $this->render('type_perfume/details.html.twig', [
        'typePerfumes' => $typePerfumes
    ]);


}
    /**
 * @Route("/typePerfume/delete/{id}", name="typePerfume_delete")

 */
public function deleteAction($id)
{
    $em = $this->getDoctrine()->getManager();
    $typePerfume = $em->getRepository(TypePerfume::class)->find($id);
    $response = $this->forward('App\Controller\ProductController::deleteAllProduct', [
        'idBrand'  => $typePerfume,
    ]);
    $em->remove($typePerfume);
    $em->flush();

    $this->addFlash(
        'error',
        'Todo deleted'
    );
    
    return $this->redirectToRoute('typePerfume_user');
}

    /**

 * @Route("/typePerfume/create", name="typePerfume_create", methods={"GET","POST"})
 */
public function createAction(Request $request)
{
    $typePerfume = new TypePerfume();
    $form = $this->createForm(TypePerfumeType::class, $typePerfume);
    
    if ($this->saveChanges($form, $request, $typePerfume)) {
        $this->addFlash(
            'notice',
            'Todo Added'
        );
        
        return $this->redirectToRoute('typePerfume_user');
    }
    
    return $this->render('type_perfume/create.html.twig', [
        'form' => $form->createView()
    ]);
}

public function saveChanges($form, $request, $typePerfume)
{
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        $typePerfume = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($typePerfume);
        $em->flush();
        
        return true;
    }
    return false;
}
/**
 * @Route("/typePerfume/edit/{id}", name="typePerfume_edit")
 */
public function editAction($id, Request $request)
{
    $em = $this->getDoctrine()->getManager();
    $typePerfume = $em->getRepository(TypePerfume::class)->find($id);

    $form = $this->createForm(typePerfumeType::class, $typePerfume);
    

    if ($this->saveChanges($form, $request, $typePerfume)) {
        $this->addFlash(
            'notice',
            'Todo Edited'
        );
        return $this->redirectToRoute('typeProduct');
    }
    
    return $this->render('type_perfume/edit.html.twig', [
        'form' => $form->createView()
    ]);
}


}
