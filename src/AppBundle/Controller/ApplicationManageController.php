<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use AppBundle\Document\Student;
use AppBundle\Document\Product;
use AppBundle\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Controller\TraitController as TraitControllers;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use AppBundle\Document\StudentApply;

class ApplicationManageController extends Controller
{
    use TraitControllers;

    private ?StudentApply $student = null;

    /**
     * @Route("/admin/application", name="applicationAdmin")
     */
    public function index(Request $request,DocumentManager $doc)
    {
        $all_student_apply = $doc->getRepository('AppBundle:StudentApply')->findBy(['status'=>1]);


        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $all_student_apply, /* query NOT result */
            $request->query->getInt('page', 1), 
            $request->query->getInt('limit', 5),     
        );

        return $this->render('admin/application/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'all_student_apply' => $pagination
        ]);
    }

    /**
     * @Route("/admin/application/search", name="searchApplicationIndex" , methods={"GET"})
     */
    public function searchIndex(Request $request,DocumentManager $doc)
    {

        $codeForm = $request->get('codeFormSearch');
        $name = $request->get('nameSearch');
        $emailRegister = $request->get('emailRegisterSearch');
        $phoneRegister = $request->get('phoneRegisterSearch');
        $array_find =[];
        if($codeForm !== ''){
            $array_find['codeForm'] = $codeForm;
        }
        if($name !== ''){
            $array_find['name'] = new \MongoDB\BSON\Regex($name);
        }
        if($emailRegister !== ''){
            $array_find['emailRegister'] = $emailRegister;
        }
        if($phoneRegister !== ''){
            $array_find['phoneRegister'] = $phoneRegister;
        }
        // $all_student = $doc->getRepository('AppBundle:Product')->findBy(['name' => new \MongoDB\BSON\Regex('oo')]);
        $value = $doc->getRepository('AppBundle:StudentApply')->findBy($array_find);
      

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $value, /* query NOT result */
            $request->query->getInt('page', 1), 
            $request->query->getInt('limit', 5),     
        );
        return $this->render('admin/application/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'all_student_apply' => $pagination
        ]);
    }



    public function setUserToCreate($name,$email,$phone,$avatar,$encoder){
        $ma = 'PH'.rand(1,9).rand(1,9).rand(1,9).rand(1,9);
        $boVietHoa = $this->userNameByNameRegister($name);
        $user_student = new User();
        $user_student->setName($name);
        $user_student->setUsername($boVietHoa.$ma);
        $encoded = $encoder->encodePassword($user_student, '12345');
        $user_student->setPassword($encoded); 
        $user_student->setAvatar($avatar); 
        $user_student->setEmail($email);
        $user_student->setPhone($phone);
        $user_student->setRole('ROLE_STUDENT');
        $user_student->setStatus(1);
        return $user_student;
    }


     /**
     * @Route("/admin/application/{id}", name="showApplication" , methods={"GET","POST"})
     */
    public function show(Request $request,DocumentManager $doc,$id,UserPasswordEncoderInterface $encoder)
    {
        // $student_Apply = new StudentApply();
        $student_Apply = $doc->getRepository('AppBundle:StudentApply')->find($id);

        if (null === $this->student) {
            $this->student = clone $student_Apply;
        }

        // $image_src = $student_Apply->getAvatar();
        $form = $this->createFormBuilder($student_Apply)
        ->add('name', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('gender', ChoiceType::class,['choices'  => [
                'Female' => 0,
                'Male' => 1,
            ],
            'attr' => ['class' => 'form-control']]
        )
        ->add('nation', ChoiceType::class,['choices'  => [
            'Kinh' => 'Kinh',
            'Tày' => 'Tày',
            'Thái' => 'Thái',
            'Mường' => 'Mường',
            'Hoa' => 'Hoa',
       ],'attr' => ['class' => 'form-control']])

        ->add('avatar', FileType::class,['required' => false,'attr' => ['class' => 'form-control'],'data_class' => null])
        ->add('birthDay', DateType::class,['attr' => ['class' => 'form-control']])

        ->add('fatherName', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('fatherIdcard', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('fatherPhone', TextType::class,['attr' => ['class' => 'form-control']])

        ->add('motherName', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('motherIdcard', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('motherPhone', TextType::class,['attr' => ['class' => 'form-control']])

        ->add('emailRegister', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('phoneRegister', TextType::class,['attr' => ['class' => 'form-control']])

        ->add('save', SubmitType::class, ['label' => 'Approve' ,'attr' => ['class' => 'btn btn-success ' , 'hidden' => true]])
        ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $student_Apply->getAvatar();
            // dump($file);
            if($file !== null){
                $file_name = md5(uniqid()).'.'.$file->guessExtension(); 
                $file->move($this->getParameter('image_directory'),$file_name);
                $student_Apply->setAvatar($file_name);
                dump(1);
            }else{
                $student_Apply->setAvatar($this->student->getAvatar());
            }
            $student_Apply->setStatus(2);
            $doc->persist($student_Apply);
            $doc->flush();         
            

            $student = new Student();
            $student->setName($student_Apply->getName());
            $student->setGender($student_Apply->getGender());
            $student->setNation($student_Apply->getNation());
            $student->setAvatar($student_Apply->getAvatar());
            $student->setbirthDay($student_Apply->getbirthDay());
            $student->setfatherName($student_Apply->getfatherName());
            $student->setfatherIdcard($student_Apply->getfatherIdcard());
            $student->setfatherPhone($student_Apply->getfatherPhone());
            $student->setmotherName($student_Apply->getmotherName());
            $student->setmotherIdcard($student_Apply->getmotherIdcard());
            $student->setmotherPhone($student_Apply->getmotherPhone());
            $student->setemailRegister($student_Apply->getemailRegister());
            $student->setphoneRegister($student_Apply->getphoneRegister());
            $student->setdayAdmission(new \DateTime());
            $student->setStatus(1);
            $student->setuserId('');
            $doc->persist($student);
            $doc->flush();  


            if($request->get('userId') == ''){
                // create new user
                $user_create =  $this->setUserToCreate($student_Apply->getName(),$student_Apply->getemailRegister(),$student_Apply->getphoneRegister(),$student_Apply->getAvatar(),$encoder);
                $doc->persist($user_create);
                $doc->flush(); 
                // update student filed userId
                $student->setuserId($user_create->getId());
                $doc->persist($student);
                $doc->flush();  
                dump('case one');
            }else{
                // update student filed userId
                $student->setuserId($request->get('userId'));
                $doc->persist($student);
                $doc->flush();  
                dump('case two');
            }
         
            $this->addFlash('notice_success','Succesfuly for student'.$student->getName());

            //  dump($request->get('userId'));
            return $this->redirectToRoute('applicationAdmin');
        }
        $all_user = $doc->getRepository('AppBundle:User')->findBy(['roles'=>['ROLE_STUDENT']]);

        return $this->render('admin/application/show.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
            'id' => $student_Apply->getId(),
            'image' => $student_Apply->getAvatar(),
            'all_user' => $all_user
        ]);
    }

    
    /**
     * @Route("/admin/application/search/tomerger", name="searchUserMerge" , methods={"POST"})
     */
    public function searchToMerge(Request $request,DocumentManager $doc)
    {

        $usernameSearch = $request->get('usernameSearch');
        $nameSearch = $request->get('nameSearch');
        $array_find =[];
        if($usernameSearch !== ''){
            $array_find['username'] = $usernameSearch;
        }
        if($nameSearch !== ''){
            $array_find['name'] = new \MongoDB\BSON\Regex($nameSearch);
        }

        $array_find['status'] = 1;
        $array_find['roles'] = ['ROLE_STUDENT'];

        $user = $doc->getRepository('AppBundle:User')->findAll($array_find);

        $data= [];
        for ($i=0; $i < count($user) ; $i++) {
            $arr = [
                'id' => $user[$i]->getId(),
                'name' => $user[$i]->getName(),
                'phone' => $user[$i]->getPhone(),
                'email' => $user[$i]->getEmail(),
                'username' => $user[$i]->getUsername(),
            ];
            $data[$i] =  $arr;
        }
        return new JsonResponse($data);
    }


     /**
     * @Route("/admin/application/remove/{id}", name="removeApplication" , methods={"DELETE"})
     */
    public function removeItem(Request $request,DocumentManager $doc,$id)
    {
        $student_Apply = $doc->getRepository('AppBundle:StudentApply')->find($id);
        $doc->remove($student_Apply);
        $doc->flush();
        return new Response('removed');
    }


  
}
