<?php
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @MongoDB\Document
 * @MongoDB\HasLifecycleCallbacks
 */
class AgeClass
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * 
     * @MongoDB\Field(type="string")
     * @MongoDB\AlsoLoad("name")
     */
    public $fullName;

    /**
     * @MongoDB\Field(type="int") 
     */
    protected $ageStudent;


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
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }

     /**
     * {@inheritDoc}
     */
    public function getFullName()
    {
        return $this->fullName;
    }



    /**
     * {@inheritDoc}
     */
    public function setageStudent($ageStudent)
    {
        $this->ageStudent = $ageStudent;
    }

    /**
     * {@inheritDoc}
     */
    public function getageStudent()
    {
        return $this->ageStudent;
    }

    /** @MongoDB\PreUpdate */
    public function preUpdate()
    {
        dump('hello');
    }

      /** @MongoDB\PostUpdate */
      public function postUpdate()
      {
          dump('helloUPdated');
      }

    /** @MongoDB\PostPersist */
    public function postPersist(\Doctrine\ODM\MongoDB\Event\LifecycleEventArgs $eventArgs)
    {
        dump($eventArgs);
    }

}   