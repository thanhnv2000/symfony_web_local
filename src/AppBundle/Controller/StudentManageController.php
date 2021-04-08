<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Document\ClassSchool;
use AppBundle\Document\Student;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class StudentManageController extends Controller
{

    private ?Student $student_global = null;



    /**
     * @Route("/admin/student", name="studentAdmin")
     */
    public function index(Request $request,DocumentManager $doc)
    {
        $students = $doc->getRepository('AppBundle:Student')->findAll(['status'=>1]);
       
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $students, /* query NOT result */
            $request->query->getInt('page', 1), 
            $request->query->getInt('limit', 5),     
        );

        return $this->render('admin/student/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'students' => $pagination
        ]);
    }


    /**
     * @Route("/admin/studentSearch", name="searchStudentIndex" , methods={"GET"})
     */
    public function searchIndex(Request $request,DocumentManager $doc)
    {

        $name = $request->get('nameSearch');
        $emailRegister = $request->get('emailRegisterSearch');
        $phoneRegister = $request->get('phoneRegisterSearch');
        $array_find =[];
       if($name !== ''){
            $array_find['name'] = new \MongoDB\BSON\Regex($name);
        }
        if($emailRegister !== ''){
            $array_find['emailRegister'] = $emailRegister;
        }
         if($phoneRegister !== ''){
            $array_find['phoneRegister'] = $phoneRegister;
        }
        
        $array_find['status'] = 1;

        $value = $doc->getRepository('AppBundle:Student')->findBy($array_find);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $value, /* query NOT result */
            $request->query->getInt('page', 1), 
            $request->query->getInt('limit', 5),     
        );


        return $this->render('admin/student/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'students' => $pagination
        ]);
    }


     /**
     * @Route("/admin/student/{id}", name="showEditStudent" , methods={"GET","POST"})
     */
    public function update(Request $request,DocumentManager $doc,$id)
    {

        $student = $doc->getRepository('AppBundle:Student')->find($id);

        if (null === $this->student_global) {
            $this->student_global = clone $student;
        }
        // $image_src = $student_Apply->getAvatar();

        $form = $this->createFormBuilder($student)
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

        ->add('save', SubmitType::class, ['label' => 'Update', 'attr' => ['class' => 'btn btn-success']])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $student->getAvatar();

            if($file !== null){
                $file_name = md5(uniqid()).'.'.$file->guessExtension(); 
                $file->move($this->getParameter('image_directory'),$file_name);
                $student->setAvatar($file_name);
            }else{
                $student->setAvatar($this->student_global->getAvatar());
            }
            $doc->persist($student);
            $doc->flush();         
            return $this->redirectToRoute('studentAdmin');

        }

        return $this->render('admin/student/show.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
            'image' => $student->getAvatar(),
        ]);

    }


}
