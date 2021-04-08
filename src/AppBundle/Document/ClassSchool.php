<?php
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class ClassSchool
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     */
    protected $name;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $ageClassId;


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
    public function setageClassId($ageClassId)
    {
        $this->ageClassId = $ageClassId;
    }

    /**
     * {@inheritDoc}
     */
    public function getageClassId()
    {
        return $this->ageClassId;
    }


}   