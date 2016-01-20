<?php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Document\Category;
use Acme\StoreBundle\Form\CategoryForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Acme\StoreBundle\Repository\ProductRepository;

class CategoryController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }


    /**
     * @Route("/category/new", name="category_new", )
     */
    public function newAction(Request $request)
    {

        $category = new Category();


        $form = $this->createForm(new CategoryForm(), $category);

        $form->handleRequest($request);

        if ($form->isValid()) {


            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($category);
            $dm->flush();


            $this->addFlash('success', 'category inserted');
            return $this->redirectToRoute('category_list', array());


        }

        return $this->render('AcmeStoreBundle:category:new.html.twig', array(

            'form' => $form->createView()
        ));
        /*return $this->render('product/new.html.twig', array(
            'med'=> 'aaaaaaa',
            'form'=>$form->createView()
        ));*/
    }


    /**
     * @Route("/categorys", name="category_list", )
     */
    public function listAction()
    {

        $repository = $this->get('doctrine_mongodb')
            ->getManager()
            ->getRepository('AcmeStoreBundle:Category');

        $categories = $repository->findAll();

        return $this->render('AcmeStoreBundle:category:list.html.twig', array(
            'categories' => $categories
        ));


    }


    /**
     * @Route("/category/delete/{id}", name="category_delete", )
     */
    public function deleteAction($id)
    {


        /*        $dm = $this->get('doctrine_mongodb')->getManager();
                $category = $dm->getRepository('AcmeStoreBundle:Category')->find($id);

                if (!$category) {
                    throw $this->createNotFoundException('No category found for id ' . $id);
                }

                $dm = $this->get('doctrine_mongodb')->getManager();
                $dm->getRepository('AcmeStoreBundle:Category')->removeProductByCategory($category);

                $dm->remove($category);
                $dm->flush();*/


        /*        $dm = $this->get('doctrine_mongodb')->getManager();
                $dm->getRepository('AcmeStoreBundle:Category')->setDefaultCategory($id);
                $dm->flush();*/


        $dm = $this->get('doctrine_mongodb')->getManager();
        $category = $dm->getRepository('AcmeStoreBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('No category found for id ' . $id);
        }


        $dm1 = $this->get('doctrine_mongodb')->getManager();
        $dm1->getRepository('AcmeStoreBundle:Product')
            ->updateProductsCategoryField($category);


        $dm->remove($category);
        $dm->flush();

        return $this->redirect($this->generateUrl('category_list'));

    }

    /**
     * @Route("/category/update/{id}", name="category_update", )
     */
    public function updateAction($id, Request $request)
    {

        $dm = $this->get('doctrine_mongodb')->getManager();
        $category = $dm->getRepository('AcmeStoreBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('No category found for id ' . $id);
        }


        $form = $this->createForm(new CategoryForm(), $category);

        $form->handleRequest($request);

        if ($form->isValid()) {


            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($category);
            $dm->flush();


            $this->addFlash('success', 'category inserted');
            return $this->redirectToRoute('category_list', array());


        }

        return $this->render('AcmeStoreBundle:category:update.html.twig', array(

            'form' => $form->createView()
        ));


    }

    /**
     * @Route("/category/show/{id}", name="category_show", )
     */
    public function showAction($id)
    {

        $dm = $this->get('doctrine_mongodb')->getManager();
        $category = $dm->getRepository('AcmeStoreBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('No category found for id ' . $id);
        }

        return $this->render('AcmeStoreBundle:category:show.html.twig', array(
            'categorie' => $category
        ));

    }


}
