<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
class UserRepository implements UserLoaderInterface
{
    private $doc;
    public function __construct(DocumentManager $dm)
    {
        $this->doc = $dm;
    }

    public function loadUserByUsername($username)
    {
        dump('get in loadUserByUsername');
        return $this->doc->getRepository('AppBundle:User')->findBy(['username'=>$username]);
    }


   
}