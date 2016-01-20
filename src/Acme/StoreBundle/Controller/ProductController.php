<?php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Document\Product;
use Acme\StoreBundle\Document\Tag;
use Acme\StoreBundle\Document\Category;
use Acme\StoreBundle\Form\ProductForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;

class ProductController extends Controller
{

    /**
     * @Route("/product/create", name="products_create", )
     */
    public function createAction(Request $request)
    {
        $product = new Product();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $tag1 = new Tag();
        $tag1->setName('tag1') ;
        $product->addTag($tag1);
        $tag2 = new Tag();
        $tag2->setName('tag12');
        $product->addTag($tag2);
        $product->setName('test');
        $product->setPrice(2.5);
        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($product);
        $dm->flush();        // end dummy code






        $form = $this->createForm(ProductForm::class, $product);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // ... maybe do some form processing, like saving the Task and Tag objects

            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($product);
            $dm->flush();


            $this->addFlash('success', 'product inserted');
            return $this->redirectToRoute('products_list', array());
        }

        return $this->render('AcmeStoreBundle:product:new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/product/new", name="products_new", )
     */
    public function newAction(Request $request)
    {

        $product = new Product();


        $form = $this->createForm(new ProductForm(), $product);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($product);
            $dm->flush();


            $this->addFlash('success', 'product inserted');
            return $this->redirectToRoute('products_list', array());


        }

        return $this->render('AcmeStoreBundle:product:new.html.twig', array(

            'form' => $form->createView()
        ));

    }






    /**
     * @Route("/product/update/{id}", name="product_update", )
     */
    public function updateAction($id,Request $request)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $product = $dm->getRepository('AcmeStoreBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }


        $form = $this->createForm(ProductForm::class, $product);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // ... maybe do some form processing, like saving the Task and Tag objects

            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($product);
            $dm->flush();


            $this->addFlash('success', 'product inserted');
            return $this->redirectToRoute('products_list', array());
        }

        return $this->render('AcmeStoreBundle:product:update.html.twig', array(

            'form' => $form->createView()
        ));



    }
    /**
     * @Route("/products", name="products_list", )
     */
    public function listAction()
    {

        $products = $this->get('doctrine_mongodb')->getManager()
            ->getRepository('AcmeStoreBundle:Product')
            ->findAllOrderedByName();

        return $this->render('AcmeStoreBundle:product:list.html.twig', array(
            'products' => $products

        ));

    }


    /**
     * @Route("/product/show/{id}", name="product_show", )
     */
    public function showAction($id)
    {

        $prod = $this->get('doctrine_mongodb')
            ->getRepository('AcmeStoreBundle:Product')
            ->find($id);

        var_dump($prod->getTags());exit();


        $originalTags = new ArrayCollection();

        // Create an ArrayCollection of the current Tag objects in the database
        foreach ($prod->getTags() as $tag) {
            $originalTags->add($tag);
        }

        if (!$prod) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        return $this->render('@AcmeStore/product/show.html.twig', array(
            'prod' => $prod


        ));

    }




    /**
     * @Route("/product/delete/{id}", name="products_delete", )
     */
    public function deleteAction($id)
    {

        $dm = $this->get('doctrine_mongodb')->getManager();
        $product = $dm->getRepository('AcmeStoreBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        $dm->remove($product);
        $dm->flush();


        return $this->redirect($this->generateUrl('products_list'));
        //return $this->render('AcmeStoreBundle:product:list.html.twig');


    }
}
