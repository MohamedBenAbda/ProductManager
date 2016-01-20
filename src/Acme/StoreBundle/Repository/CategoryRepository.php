<?php

namespace Acme\StoreBundle\Repository;


namespace Acme\StoreBundle\Repository;

use Acme\StoreBundle\Document\Category;
use Acme\StoreBundle\Document\Product;
use Doctrine\ODM\MongoDB\DocumentRepository;


/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends DocumentRepository
{


    public function setDefaultCategory($id)
    {
        $this->createQueryBuilder('Category')
            ->findAndUpdate()
            ->field('name')->set('choisissez une catégorie')
            ->field('_id')->equals($id)
            ->getQuery()
            ->execute();

    }


    public function removeProductByCategory(Category $category)
    {
        return $this->createQueryBuilder('Product')
            ->findAndRemove()
            ->field('categorie')->references($category)
            ->getQuery()
            ->execute();
    }







}