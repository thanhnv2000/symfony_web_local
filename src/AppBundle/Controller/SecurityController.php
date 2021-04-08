<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Document\User;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SecurityController extends Controller
{

     /**
     * @Route("/login", name="login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils,AuthorizationCheckerInterface $authChecker)
    {
        
        if (true === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('applicationAdmin');
        }
        
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }


      /**
     * @Route("/login/create", name="createlogin")
     */
    public function created(UserPasswordEncoderInterface $encoder,DocumentManager $dm)
    {
        $user = new User();
        $user->setName('Teacher1');
        $user->setUsername('userTeacher');
        $encoded = $encoder->encodePassword($user, '12345');
        $user->setPassword($encoded);
        $user->setRole('ROLE_TEACHER');
        $dm->persist($user);
        $dm->flush();
        return $this->render('admin/base/base.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

     /**
     * @Route("/forgotSubmit", name="forgotSubmit" , methods={"POST"})
     */
    public function forgotSubmit(Request $request,\Swift_Mailer $mailer,DocumentManager $doc,UserPasswordEncoderInterface $encoder)
    {
        $username = $request->get('username');

        $this_user = $doc->getRepository("AppBundle:User")->findOneBy(['username'=> $username]);
        $error = '';
        if($this_user == null){
             $error = 'Username not correct this no have in systemt';
             dump('hifew');
        }else if($this_user->getStatus() !== 1){
             $error = 'This account was disabled';
             dump('hife2w');
        }

        if($error !== ''){
            return $this->render('security/forgotPass.html.twig', [
                'error' => $error
            ]);
        }

        $passRand = rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9);
        $encoded = $encoder->encodePassword($this_user, $passRand);
        $this_user->setPassword($encoded);
        $doc->persist($this_user);
        $doc->flush();

        $message = (new \Swift_Message('Hello Email'))
        ->setFrom('thanhnv2bn@gmail.com')
        ->setTo($this_user->getEmail())
        ->setBody("
            Hi".$username."
            <p>Your new password is ".$passRand." </p>
            <p>Please change your password now</p>
            ", 'text/html');
        $mailer->send($message);

        return $this->render('security/forgotPass.html.twig', [
            'success' => 'We have send new password in your mail please check your email'
        ]);

    }

     /**
     * @Route("/forgotpassword", name="forgotPassword")
     */
    public function forgotpass(Request $request,\Swift_Mailer $mailer,DocumentManager $doc,UserPasswordEncoderInterface $encoder)
    {
        return $this->render('security/forgotPass.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}