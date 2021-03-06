<?php

namespace Acme\StoreBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="Acme\StoreBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $name;

    /**
     * @MongoDB\Float
     */
    protected $price;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Acme\StoreBundle\Document\Category")
     */
    public $categorie;


    /**
     * @MongoDB\EmbedMany(targetDocument="Acme\StoreBundle\Document\Tag")
     */
    protected $tags;



    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return self
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Get price
     *
     * @return float $price
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set categorie
     *
     * @param Acme\StoreBundle\Document\Category $categorie
     * @return self
     */
    public function setCategorie(\Acme\StoreBundle\Document\Category $categorie)
    {
        $this->categorie = $categorie;
        return $this;
    }

    /**
     * Get categorie
     *
     * @return Acme\StoreBundle\Document\Category $categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }


    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add tag
     *
     * @param Acme\StoreBundle\Document\Tag $tag
     */
    public function addTag(\Acme\StoreBundle\Document\Tag $tag)
    {
        $this->tags[] = $tag;
    }

    /**
     * Remove tag
     *
     * @param Acme\StoreBundle\Document\Tag $tag
     */
    public function removeTag(\Acme\StoreBundle\Document\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection $tags
     */
    public function getTags()
    {
        return $this->tags;
    }
}
