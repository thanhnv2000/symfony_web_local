<?php
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
/**
 * @MongoDB\Document
 */
class Student
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
     * @MongoDB\Field(type="int")
     */
    protected $gender;

     /**
     * @MongoDB\Field(type="string")
     */
    protected $avatar;

    /**
     * @MongoDB\Field(type="date")
     */
    protected $birthDay;


     /**
     * @MongoDB\Field(type="string")
     */
    protected $nation;


    /**
     * @MongoDB\Field(type="date")
     */
    protected $dayAdmission;
   

     /**
     * @MongoDB\Field(type="string")
     */
    protected $fatherName;


    /**
     * @MongoDB\Field(type="string")
     */
    protected $fatherIdcard;
   
     
    /**
     * @MongoDB\Field(type="string")
     */
    protected $fatherPhone;


    /**
     * @MongoDB\Field(type="string")
     */
    protected $motherName;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $motherIdcard;

     /**
     * @MongoDB\Field(type="string")
     */
    protected $motherPhone;



    /**
     * @MongoDB\Field(type="string")
     */
    protected $emailRegister;
    
    /**
     * @MongoDB\Field(type="string")
     */
    protected $phoneRegister;

   
    /**
     * @MongoDB\Field(type="int")
     */
    protected $status;


    /**
     * @MongoDB\Field(type="string")
     */
    protected $userId;


       /**
     * @MongoDB\Field(type="string")
     */
    protected $classId;


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
    public function getbirthDay()
    {
        return $this->birthDay;
    }

    /**
     * {@inheritDoc}
     */
    public function setbirthDay($birthDay)
    {
        $this->birthDay = $birthDay;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getNation()
    {
        return $this->nation;
    }

    /**
     * {@inheritDoc}
     */
    public function setNation($nation)
    {
        $this->nation = $nation;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getdayAdmission()
    {
        return $this->dayAdmission;
    }

    /**
     * {@inheritDoc}
     */
    public function setdayAdmission($dayAdmission)
    {
        $this->dayAdmission = $dayAdmission;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getfatherName()
    {
        return $this->fatherName;
    }

    /**
     * {@inheritDoc}
     */
    public function setfatherName($fatherName)
    {
        $this->fatherName = $fatherName;

        return $this;
    }


    /**
     * {@inheritDoc}
     */
    public function getfatherIdcard()
    {
        return $this->fatherIdcard;
    }

    /**
     * {@inheritDoc}
     */
    public function setfatherIdcard($fatherIdcard)
    {
        $this->fatherIdcard = $fatherIdcard;

        return $this;
    }


    /**
     * {@inheritDoc}
     */ 
    public function getfatherPhone()
    {
        return $this->fatherPhone;
    }

    /**
     * {@inheritDoc}
     */
    public function setfatherPhone($fatherPhone)
    {
        $this->fatherPhone = $fatherPhone;

        return $this;
    }

    

    /**
     * {@inheritDoc}
     */
    public function getmotherName()
    {
        return $this->motherName;
    }

    /**
     * {@inheritDoc}
     */
    public function setmotherName($motherName)
    {
        $this->motherName = $motherName;

        return $this;
    }

     /**
     * {@inheritDoc}
     */
    public function getmotherIdcard()
    {
        return $this->motherIdcard;
    }

     /**
     * {@inheritDoc}
     */
    public function setmotherIdcard($motherIdcard)
    {
        $this->motherIdcard = $motherIdcard;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getmotherPhone()
    {
        return $this->motherPhone;
    }

    /**
     * {@inheritDoc}
     */
    public function setmotherPhone($motherPhone)
    {
        $this->motherPhone = $motherPhone;

        return $this;
    }


    /**
     * {@inheritDoc}
     */
    public function getemailRegister()
    {
        return $this->emailRegister;
    }

    /**
     * {@inheritDoc}
     */
    public function setemailRegister($emailRegister)
    {
        $this->emailRegister = $emailRegister;

        return $this;
    }

   /**
     * {@inheritDoc}
     */
    public function getphoneRegister()
    {
        return $this->phoneRegister;
    }

   /**
     * {@inheritDoc}
     */
    public function setphoneRegister($phoneRegister)
    {
        $this->phoneRegister = $phoneRegister;

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
    public function getuserId()
    {
        return $this->userId;
    }

   /**
     * {@inheritDoc}
     */
    public function setuserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

   

    /**
     * Get the value of classId
     */ 
    public function getClassId()
    {
        return $this->classId;
    }

    /**
     * Set the value of classId
     *
     * @return  self
     */ 
    public function setClassId($classId)
    {
        $this->classId = $classId;

        return $this;
    }
}   