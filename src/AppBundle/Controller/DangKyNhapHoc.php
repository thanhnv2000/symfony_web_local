<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Document\StudentApply;
use AppBundle\Document\Product;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\HttpFoundation\Response;

class DangKyNhapHoc extends Controller
{
    /**
     * @Route("/ssssssssss", name="dangkynhaphoc")
     */
    public function index(Request $request,DocumentManager $dm,\Swift_Mailer $mailer)
    {
    
        // $product = new Product();
        // $form = $this->createFormBuilder($product)
        //     ->add('name', TextType::class)
        //     ->add('save', SubmitType::class, ['label' => 'Create product'])
        //     ->getForm();

        // $test = new Test();
        // $test->setName('hihihi');
        // $dm->persist($test);
        // $dm->flush();
        
           
            $student_Apply = new StudentApply();
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
                ->add('avatar', FileType::class,[ 'attr' => ['class' => 'form-control-file']])
                ->add('birthDay', DateType::class,['attr' => ['class' => 'form-control']])

                ->add('fatherName', TextType::class,['attr' => ['class' => 'form-control']])
                ->add('fatherIdcard', TextType::class,['attr' => ['class' => 'form-control']])
                ->add('fatherPhone', TextType::class,['attr' => ['class' => 'form-control']])

                ->add('motherName', TextType::class,['attr' => ['class' => 'form-control']])
                ->add('motherIdcard', TextType::class,['attr' => ['class' => 'form-control']])
                ->add('motherPhone', TextType::class,['attr' => ['class' => 'form-control']])

                ->add('emailRegister', TextType::class,['attr' => ['class' => 'form-control']])
                ->add('phoneRegister', TextType::class,['attr' => ['class' => 'form-control']])

                
                ->add('save', SubmitType::class, ['label' => 'Create to apply' ,'attr' => ['class' => 'btn btn-success ']])
                ->getForm();

            $form->handleRequest($request);
            $validator = $this->get('validator');
            $errors = $validator->validate($student_Apply);
        

        if ($form->isSubmitted() && $form->isValid()) {
    
            $file = $student_Apply->getAvatar();
            $file_name = md5(uniqid()).'.'.$file->guessExtension(); 
            $file->move($this->getParameter('image_directory'),$file_name);
            $student_Apply->setAvatar($file_name);

            $rand_verifi =  rand(1,9).rand(1,9).rand(1,9 ).rand(1,9).rand(1,9);
            $student_Apply->setVerification($rand_verifi);

            $rand_code_form = substr(md5(microtime()),rand(0,26),10);
            $student_Apply->setcodeForm($rand_code_form);

            $student_Apply->setStatus(0);

            $message = (new \Swift_Message('Hello Email'))
            ->setFrom('thanhnv2bn@gmail.com')
            ->setTo('thanhnvph07471@fpt.edu.vn')
            ->setBody(
                $this->renderView(
                    'Email/email.html.twig',[
                        'verification' => $rand_verifi
                    ]
                ),
                'text/html'
                );
            $mailer->send($message);


            $dm->persist($student_Apply);
            $dm->flush();
            $this->addFlash(
                'id_form',
                $student_Apply->getId()
            );
        }


        return $this->render('client/dangkynhaphoc.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
            'errors' => $errors,
        ]);
    }


     /**
     * @Route("/dangkynhaphoc/access_verifi/{id}", name="access_verifi" , methods={"POST"})
     */
    public function access_veritifi(Request $request,$id,DocumentManager $dm)
    {
        $identification1 = $request->get('ma_xac_thuc1');
        $identification2 = $request->get('ma_xac_thuc2');
        $identification3 = $request->get('ma_xac_thuc3');
        $identification4 = $request->get('ma_xac_thuc4');
        $identification5 = $request->get('ma_xac_thuc5');
        $identification_get = $identification1.$identification2.$identification3.$identification4.$identification5;

        $find_studentapply=  $dm->getRepository('AppBundle:StudentApply')->find($id);
        $verfication_studentapply = $find_studentapply->getVerification();

        if($identification_get == $verfication_studentapply){
            $find_studentapply->setStatus(1);
            $dm->persist($find_studentapply);
            $dm->flush();
            return new Response(
                $find_studentapply->getcodeForm()
            );
        }else{
            return new Response(
                'No'
            );
        }

    }

     /**
     * @Route("/dangkynhaphoc", name="dangky")
     */
    public function dangkynhaphoc(Request $request,DocumentManager $dm,\Swift_Mailer $mailer)
    {
   
        // $message = (new \Swift_Message('Hello Email'))
        // ->setFrom('thanhnv2bn@gmail.com')
        // ->setTo('thanhnvph07471@fpt.edu.vn')
        // ->setBody(
        //     $this->renderView(
        //         'Email/email.html.twig',
        //     ),
        //     'text/html'
        //     )
        // ;
        // $mailer->send($message);

        return $this->render('admin/base/base.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

}
