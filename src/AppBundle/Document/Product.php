<?php
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
/**
 * @MongoDB\Document
 * @MongoDB\Indexes({
 *   @MongoDB\Index(keys={"name"="asc"}),
 *   @MongoDB\Index(keys={"price"="asc"})
 * })
 */
class Product
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * @MongoDB\Field(type="float")
     */
    protected $price;

     /**
     * @MongoDB\Field(type="date")
     */
    protected $created_at;

     /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

     /**
     * {@inheritDoc}
     */
    public function setName($name)
    {
        $this->name = $name;
    }

     /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * {@inheritDoc}
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * {@inheritDoc}
     */
    public function getPrice()
    {
        return $this->price;
    }

     /**
     * {@inheritDoc}
     */
    public function setCreated_at($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * {@inheritDoc}
     */
    public function getCreated_at()
    {
        return $this->created_at;
    }



}   