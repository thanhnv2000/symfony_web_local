<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Document\AgeClass;
use AppBundle\Document\ClassSchool;
use AppBundle\Document\Teacher;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class AgeClassManageController extends Controller
{
    /**
     * @Route("/admin/ageclass", name="age_class")
     */
    public function index(Request $request,DocumentManager $doc)
    {
        $all_khoi = $doc->getRepository('AppBundle:AgeClass')->findAll();
        $class_all = $doc->getRepository('AppBundle:ClassSchool')->findAll();

    
    
        // $update = $doc->createQueryBuilder(Teacher::class)->field('id')->all(['600537e3d7921b487b606c9f', '60053d9bd7921b487b606ca1'])
        // ->getQuery()
        // ->execute();
        // dump($update);

        $class_no_ageClass = $doc->getRepository('AppBundle:ClassSchool')->findBy(['ageClassId' => '0']);

        $khoi_info = [];
        foreach($all_khoi as $khoi){
            $arr_class_of_khoi = [];
            foreach($class_all as $lop){
                if($lop->getageClassId() == $khoi->getId()){
                    array_push($arr_class_of_khoi,$lop);
                }
            }
            $khoi->class_of_khoi = $arr_class_of_khoi;
            array_push($khoi_info,$khoi);
        }   

        //  cho nhung class ko co khoi
        $element_no_khoi['id'] = '0';
        $element_no_khoi['name'] = 'No have age class ';
        // 
        $arr_class_no_have_khoi=[];
        foreach($class_no_ageClass as $class_no_age){
             array_push($arr_class_no_have_khoi, $class_no_age);
        }
        $element_no_khoi['class_of_khoi'] = $arr_class_no_have_khoi;
        $object_no_have =  (object) $element_no_khoi;
        array_push($khoi_info,$object_no_have);
        //  
        dump($khoi_info);
        // replace this example code with whatever you need
        return $this->render('admin/ageclass/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'all_khoi' => $all_khoi,
            'khoi_info' => $khoi_info
        ]);
    }


     /**
     * @Route("/admin/ageclass/add", name="addNewAgeClass" , methods={"GET","POST"})
     */
    public function store(Request $request,DocumentManager $doc)
    {
        $age_class = new AgeClass();

        $form = $this->createFormBuilder($age_class)
        ->add('name', TextType::class,['attr' => ['class' => 'form-control'] , 'required' => false])
        ->add('ageStudent', ChoiceType::class,['choices'  => [
            'For 1 year' => 1,
            'For 2 year' => 2,
            'For 3 year' => 3,
            'For 4 year' => 4,
            'For 5 year' => 5,
       ],'attr' => ['class' => 'form-control']])
        ->add('save', SubmitType::class, ['label' => 'Add' ,'attr' => ['class' => 'btn btn-success']])
        ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doc->persist($age_class);
            $doc->flush();         
            return $this->redirectToRoute('age_class');
        }
        return $this->render('admin/ageclass/add.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/admin/ageclass/{id}", name="editAgeClass" , methods={"GET","POST"})
     */
    public function update(Request $request,DocumentManager $doc,$id)
    {
        $age_class = $doc->getRepository('AppBundle:AgeClass')->find($id);

        $form = $this->createFormBuilder($age_class)
        ->add('name', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('ageStudent', ChoiceType::class,['choices'  => [
            'For 1 year' => 1,
            'For 2 year' => 2,
            'For 3 year' => 3,
            'For 4 year' => 4,
            'For 5 year' => 5,
       ],'attr' => ['class' => 'form-control']])
        ->add('save', SubmitType::class, ['label' => 'Edit' ,'attr' => ['class' => 'btn btn-success']])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doc->persist($age_class);
            $doc->flush();         
            return $this->redirectToRoute('age_class');
        }

        return $this->render('admin/ageclass/edit.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
            'id' => $age_class->getId(),
        ]);
    }





    




    /**
     * @Route("/admin/ageclass/search", name="searchAgeClass" , methods={"POST"})
     */
    public function searchIndex(Request $request,DocumentManager $doc)
    {

        $codeForm = $request->get('codeFormSearch');
        $name= $request->get('nameSreach');
        $emailRegister = $request->get('emailRegisterSearch');
        $phoneRegister = $request->get('phoneRegisterSearch');
        $array_find =[];
        if($codeForm !== ''){
            $array_find['codeForm'] = $codeForm;
        }else if($emailRegister !== ''){
            $array_find['emailRegister'] = $emailRegister;
        }else if($phoneRegister !== ''){
            $array_find['phoneRegister'] = $phoneRegister;
        }
        // $all_student = $doc->getRepository('AppBundle:Product')->findBy(['name' => new \MongoDB\BSON\Regex('oo')]);
        $value = $doc->getRepository('AppBundle:AgeClass')->findBy($array_find);
      
        return $this->render('admin/application/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'all_student_apply' => $value
        ]);
    }


     /**
     * @Route("/admin/ageclass/remove/{id}", name="removeAgeClass" , methods={"DELETE"})
     */
    public function removeItem(Request $request,DocumentManager $doc,$id)
    {
        $all_classOfAge = $doc->createQueryBuilder(ClassSchool::class)
        ->findAndUpdate()->field('ageClassId')->equals($id)
        ->field('ageClassId')->set(0)
        ->getQuery()
        ->execute();
        
        $ageclass = $doc->getRepository('AppBundle:AgeClass')->find($id);
        $doc->remove($ageclass);
        $doc->flush();


        return new Response('removed');
    }



}
