<?php

namespace AppBundle\Security;

use AppBundle\Exception\AccountDeletedException;
use AppBundle\Document\User;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\Exception\CustumerException;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Component\HttpFoundation\Response;

class UserChecker implements UserCheckerInterface
{
    
    private $doc;
    public function __construct(DocumentManager $document)
    {
        $this->doc = $document;
    }

    public function checkPreAuth(UserInterface $user)
    {
        $get_user = $this->doc->getRepository('AppBundle:User')->findOneBy(['username' => $user->getUsername()]);
        if ($get_user->getStatus() == 0) {
            throw new DisabledException();
        }

        if (true !== in_array("ROLE_ADMIN", $get_user->getRoles())) {
           $exception = new CustumerException();
           $exception->setMessage('Account is not suitable with app');
           throw $exception;
        }
       
    }

    public function checkPostAuth(UserInterface $user)
    {
       
    }
}