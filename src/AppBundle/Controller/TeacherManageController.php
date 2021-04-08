<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Document\Teacher;
use AppBundle\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use AppBundle\Controller\TraitController as TraitControllers;

class TeacherManageController extends Controller
{
    use TraitControllers;

    private ?Teacher $teacher_fix = null;


    /**
     * @Route("/admin/teacher", name="teacher")
     */
    public function index(Request $request,DocumentManager $doc)
    {
        $teacher_all = $doc->getRepository('AppBundle:Teacher')->findAll();

          
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $teacher_all, /* query NOT result */
            $request->query->getInt('page', 1), 
            $request->query->getInt('limit', 5),     
        );

        // replace this example code with whatever you need
        return $this->render('admin/teacher/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'teacher_all' => $pagination
        ]);
    }


     /**
     * @Route("/admin/teacher/add", name="addNewTeacher" , methods={"GET","POST"})
     */
    public function store(Request $request,DocumentManager $doc,UserPasswordEncoderInterface $encoder,\Swift_Mailer $mailer)
    {
        $teacher = new Teacher();

        $class_all =  $doc->getRepository('AppBundle:ClassSchool')->findAll();
        $arr_class_choose= [];
        foreach($class_all as $class){
            $arr_class_choose[$class->getName()]= $class->getId();
        }
        
        $form = $this->createFormBuilder($teacher)
        ->add('name', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('gender', ChoiceType::class,['choices'  => [
            'Female' => 0,
            'Male' => 1,
            ],
            'attr' => ['class' => 'form-control']]
        )
        ->add('email', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('birthDay', DateType::class,['attr' => ['class' => 'form-control']])
        ->add('avatar', FileType::class,['attr' => ['class' => 'form-control']])
        ->add('phone', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('level', TextType::class,['attr' => ['class' => 'form-control']])     
        ->add('educatePlace', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('address', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('idCard', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('save', SubmitType::class, ['label' => 'Add teacher' ,'attr' => ['class' => 'btn btn-success mt-2 ']])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $teacher->getAvatar();
            $file_name = md5(uniqid()).'.'.$file->guessExtension(); 
            $file->move($this->getParameter('image_directory'),$file_name);
            $teacher->setAvatar($file_name);

            $ma_giao_vien = 'PT'.rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9);
            $teacher->setCodeTeacher($ma_giao_vien);

             $boVietHoa = $this->userNameByNameRegister($teacher->getName());

             $user_for_teacher = new User();
             $user_for_teacher->setName($teacher->getName());
             $user_for_teacher->setUsername($boVietHoa.$ma_giao_vien);
             $encoded = $encoder->encodePassword($user_for_teacher, '12345');
             $user_for_teacher->setPassword($encoded); 
             $user_for_teacher->setAvatar($teacher->getAvatar()); 
             $user_for_teacher->setEmail($teacher->getEmail());
             $user_for_teacher->setPhone($teacher->getPhone());
             $user_for_teacher->setRole('ROLE_TEACHER');
             $user_for_teacher->setStatus(1);
             $doc->persist($user_for_teacher);
             $doc->flush();     


             $teacher->setclassId('');
             $teacher->setUserId($user_for_teacher->getId());
             $doc->persist($teacher);
             $doc->flush();         
 
            // send email
             $message = (new \Swift_Message('Hello Email'))
             ->setFrom('thanhnv2bn@gmail.com')
             ->setTo($user_for_teacher->getEmail())
             ->setBody(
                 $this->renderView(
                     'Email/emailAccount.html.twig',[
                         'username' => $boVietHoa.$ma_giao_vien,
                         'password' => '12345'
                     ]
                 ),
                 'text/html'
                 );
             $mailer->send($message);

            return $this->redirectToRoute('teacher');
        }
        return $this->render('admin/teacher/add.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin/teacher/search", name="searchTeacher" , methods={"GET"})
     */
    public function searchIndex(Request $request,DocumentManager $doc)
    {
        $codeTeacher = $request->get('codeTeacher');
        $name= $request->get('nameSearch');
        $array_find =[];
        if($codeTeacher !== ''){
            $array_find['codeTeacher'] = $codeTeacher;  
        }
        if($name !== ''){
            $array_find['name'] = new \MongoDB\BSON\Regex($name);
        }
        $value = $doc->getRepository('AppBundle:Teacher')->findBy($array_find);
      
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $value, /* query NOT result */
            $request->query->getInt('page', 1), 
            $request->query->getInt('limit', 5),     
        );

        return $this->render('admin/teacher/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'teacher_all' => $pagination
        ]);
    }




     /**
     * @Route("/admin/teacher/{id}", name="editTeacher" , methods={"GET","POST"})
     */
    public function update(Request $request,DocumentManager $doc,$id)
    {
        // $student_Apply = new StudentApply();
        $teacher_get = $doc->getRepository('AppBundle:Teacher')->find($id);
        if (null === $this->teacher_fix) {
            $this->teacher_fix = clone $teacher_get;
        }

        $form = $this->createFormBuilder($teacher_get)
        ->add('name', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('gender', ChoiceType::class,['choices'  => [
            'Female' => 0,
            'Male' => 1,
            ],
            'attr' => ['class' => 'form-control']]
        )
        ->add('email', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('birthDay', DateType::class,['attr' => ['class' => 'form-control']])
        ->add('avatar', FileType::class,['required' => false,'attr' => ['class' => 'form-control'],'data_class' => null])
        ->add('phone', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('level', TextType::class,['attr' => ['class' => 'form-control']])     
        ->add('educatePlace', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('address', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('idCard', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('save', SubmitType::class, ['label' => 'Update' ,'attr' => ['class' => 'btn btn-success mt-2 ']])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $teacher_get->getAvatar();
            if($file !== null){
                $file_name = md5(uniqid()).'.'.$file->guessExtension(); 
                $file->move($this->getParameter('image_directory'),$file_name);
                $teacher_get->setAvatar($file_name);
                dump(1);
            }else{
                $teacher_get->setAvatar($this->teacher_fix->getAvatar());
            }
            $teacher_get->setclassId('');
            $doc->persist($teacher_get);
            $doc->flush();
            return $this->redirectToRoute('teacher');
        }

        return $this->render('admin/teacher/edit.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
            'id' => $teacher_get->getId(),
            'image' => $teacher_get->getAvatar()
        ]);
    }


    
}
