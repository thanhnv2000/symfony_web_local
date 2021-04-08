<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use AppBundle\Document\Account;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InfoManageController extends Controller
{

     /**
     * @Route("/admin/info", name="infoUser")
     */
    public function index(Request $request,DocumentManager $doc)
    {
        return $this->render('admin/info/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/admin/info/changeuser", name="infoChangePassword")
     */
    public function changePassword(Request $request,DocumentManager $doc)
    {
        return $this->render('admin/info/changePassword.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/admin/info/submitchangeuser", name="infoSubmitChangePassword" , methods={"POST"})
     */
    public function submitChangePassword(Request $request,DocumentManager $doc,UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();
        $old_pwd = $request->get('old_pwd'); 
        $new_pwd = $request->get('new_pwd'); 
        $new_pwd_confirm = $request->get('pwd_confirm');
        $checkPass = $passwordEncoder->isPasswordValid($user, $old_pwd);

        if($checkPass == false){
            $this->addFlash('error','Old password it s not correct');
        }else if($new_pwd !== $new_pwd_confirm){
            $this->addFlash('error','Password confirm not correct');
        }else{
            $new_pwd_encoded = $passwordEncoder->encodePassword($user, $new_pwd_confirm); 
            $user->setPassword($new_pwd_encoded);
            $doc->persist($user);
            $doc->flush();
            $this->addFlash('success','Successfully changed password');

        }

        return $this->render('admin/info/changePassword.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
       
    }
    

}
