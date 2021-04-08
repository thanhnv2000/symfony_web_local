<?php
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class StudentApply
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
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min = 5)
     */
    protected $fatherName;


    /**
     * @MongoDB\Field(type="string")  
     * @Assert\NotBlank()
     * @Assert\Length(min = 5)
     */
    protected $fatherIdcard;
   
     
    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="numeric"
     * )
     * @Assert\Length(min = 10)
     */
    protected $fatherPhone;


    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min = 5)
     */
    protected $motherName;

    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min = 10)
     */
    protected $motherIdcard;

     /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min = 10)
     * @Assert\Type(
     *     type="numeric"
     * )
     */
    protected $motherPhone;


    /**
     * @MongoDB\Field(type="string")
     */
    protected $verification;


    /**
     * @MongoDB\Field(type="string")  
     * @Assert\NotBlank()
     * @Assert\Email( message = "The type is not a valid email.")
     */
    protected $emailRegister;
    
    /**
     * @MongoDB\Field(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min = 10)
     * @Assert\Type(
     *     type="numeric"
     * )
     */
    protected $phoneRegister;


    /**
     * @MongoDB\Field(type="string")
     */
    protected $codeForm;

    /**
     * @MongoDB\Field(type="int")
     */
    protected $status;


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
    public function getVerification()
    {
        return $this->verification;
    }

    /**
     * {@inheritDoc}
     */
    public function setVerification($verification)
    {
        $this->verification = $verification;

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
    public function getcodeForm()
    {
        return $this->codeForm;
    }

    /**
     * {@inheritDoc}
     */
    public function setcodeForm($codeForm)
    {
        $this->codeForm = $codeForm;

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


   
}   