<?php
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @MongoDB\Document
 */
class Teacher
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min = 5)
     */
    protected $name;


     /**
     * @MongoDB\Field(type="string")
     */
    protected $codeTeacher;
 
    /**
     * @MongoDB\Field(type="int")
     */
    protected $gender;


     /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     * @Assert\Email( message = "The type is not a valid email.")
     */
    protected $email;


     /**
     * @MongoDB\Field(type="date")
     */
    protected $birthDay;


     /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min = 10)
     * @Assert\Type(
     *     type="numeric"
     * )
     */
    protected $phone;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $avatar;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $level;

     /**
     * @MongoDB\Field(type="string")
     */
    protected $educatePlace;   

    /**
     * @MongoDB\Field(type="string")
     */
    protected $address;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $idCard;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $status;


    /**
     * @MongoDB\Field(type="string")
     */
    protected $classId;


     /**
     * @MongoDB\Field(type="string")
     */
    protected $userId;


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
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * {@inheritDoc}
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * {@inheritDoc}
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * {@inheritDoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getBirthDay()
    {
        return $this->birthDay;
    }

    /**
     * {@inheritDoc}
     */
    public function setBirthDay($birthDay)
    {
        $this->birthDay = $birthDay;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * {@inheritDoc}
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * {@inheritDoc}
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * {@inheritDoc}
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function geteducatePlace()
    {
        return $this->educatePlace;
    }

    /**
     * {@inheritDoc}
     */
    public function seteducatePlace($educatePlace)
    {
        $this->educatePlace = $educatePlace;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * {@inheritDoc}
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getIdCard()
    {
        return $this->idCard;
    }

    /**
     * {@inheritDoc}
     */
    public function setIdCard($idCard)
    {
        $this->idCard = $idCard;

        return $this;
    }

    /**
     * {@inheritDoc}
     */ 
    public function getStatus()
    {
        return $this->status;
    }

     /**
     * {@inheritDoc}
     */ 
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

     /**
     * {@inheritDoc}
     */ 
    public function getClassId()
    {
        return $this->classId;
    }

     /**
     * {@inheritDoc}
     */ 
    public function setClassId($classId)
    {
        $this->classId = $classId;

        return $this;
    }

     /**
     * {@inheritDoc}
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * {@inheritDoc}
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * {@inheritDoc}
     */ 
    public function getCodeTeacher()
    {
        return $this->codeTeacher;
    }

    /**
     * {@inheritDoc}
     */ 
    public function setCodeTeacher($codeTeacher)
    {
        $this->codeTeacher = $codeTeacher;

        return $this;
    }
}   