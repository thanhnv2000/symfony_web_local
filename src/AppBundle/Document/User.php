<?php
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @MongoDB\Document
 */
class User implements UserInterface
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
     * @MongoDB\Field(type="string")
     */
    protected $username;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $password;


    /**
     * @MongoDB\Field(type="string")
     */
    protected $avatar;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $email;


    /**
     * @MongoDB\Field(type="string")
     */
    protected $phone;


    /**
     * @MongoDB\Field(type="collection")
     */
    protected $roles = array();

    /**
     * @MongoDB\Field(type="string")
     */
    protected $salt;


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
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * {@inheritDoc}
     */
    public function getUsername()
    {
        return $this->username;
    }
    



    /**
     * {@inheritDoc}
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * {@inheritDoc}
     */
    public function setPassword($password)
    {
        $this->password = $password;

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
     * @param String
     */
    public function setRole($role)
    {
        $this->roles[] = $role;
    }

    /**
     * @param array
     */
    public function setRoles(array $roles)
    {
        $this->roles = (array) $roles;
    }


    /**
     * @return array
     */
    public function getRoles()
    {
        return  $this->roles;
    }

    /**
     * @return String
     */
    public function getSalt()
    {
        return $this->salt;
    }
     /**
     * @param String
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }


    public function __construct()
    {
        $this->isActive = true;
        $this->salt = '';
    }

    public function isEqualTo(UserInterface $user)
    {
        return $user->getUsername() === $this->username;
    }

    public function eraseCredentials()
    {
    }
}   