<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Form\ProductType;


class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="app_product")
     */
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * @Route("/home/product",name="product_user")
     */
    public function indexActionUser()
    {
        
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', array(
            'products' => $products,
        ));
    }
    /**
 * @Route("/Product/details/{id}", name="Product_details")
 */
public
function detailsAction($id)
{
    
    $em = $this->getDoctrine()->getManager();

    $product = $em->getRepository(Product::class)->find($id);

    return $this->render('product/details.html.twig', [
        'product' => $product
    ]);


}
    /**
 * @Route("/Product/delete/{id}", name="Product_delete")

 */
public function deleteAction($id)
{
    $em = $this->getDoctrine()->getManager();
    $product = $em->getRepository(Product::class)->find($id);
    $em->remove($product);
    $em->flush();

    $this->addFlash(
        'error',
        'Todo deleted'
    );
    
    return $this->redirectToRoute('product_user');
}

    /**

 * @Route("/Product/create", name="Product_create", methods={"GET","POST"})
 */
public function createAction(Request $request)
{
    $products = new Product();
    $form = $this->createForm(ProductType  ::class, $products);
    
    if ($this->saveChanges($form, $request, $products)) {
        $this->addFlash(
            'notice',
            'Todo Added'
        );
        
        return $this->redirectToRoute('product_user');
    }
    
    return $this->render('product/create.html.twig', [
        'form' => $form->createView()
    ]);
}

public function saveChanges($form, $request, $products)
{
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        $products = $form->getData();
        $em = $this->getDoctrine()->getManager();
        $em->persist($products);
        $em->flush();
        
        return true;
    }
    return false;
}
/**
 * @Route("/Product/edit/{id}", name="Product_edit")
 */
public function editAction($id, Request $request)
{
    $em = $this->getDoctrine()->getManager();
    $product = $em->getRepository(Product::class)->find($id);
    
    $form = $this->createForm(ProductType::class, $product);
    
    if ($this->saveChanges($form, $request, $product)) {
        $this->addFlash(
            'notice',
            'Todo Edited'
        );
        return $this->redirectToRoute('product_user');
    }
    
    return $this->render('product/edit.html.twig', [
        'form' => $form->createView()
    ]);
}
public function deleteAllProduct($idBrand){
    $em = $this->getDoctrine()->getManager();
    $product = $em->getRepository(Product::class)->find($idBrand);

    $products = $em->getRepository('App\Entity\Product')->findBy(['brand' => $idBrand]);
    foreach($products as $item){
        $em->remove($item);
        $em->flush();
    }       
     return true;

}
}
