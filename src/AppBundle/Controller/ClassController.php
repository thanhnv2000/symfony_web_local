<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Document\ClassSchool;
use AppBundle\Document\Teacher;
use AppBundle\Document\Student;
use AppBundle\Document\StudentApply;
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


class ClassController extends Controller
{

    /**
     * @Route("/admin/class/{id_class}", defaults={"id_class"=null}  , name="class_index")
     */
    public function index(Request $request,DocumentManager $doc,$id_class)
    {
     
        $all_class = $doc->getRepository('AppBundle:ClassSchool')->findAll();

        foreach($all_class as $class){
            $total =  $doc->createQueryBuilder(Student::class)
            ->field('classId')->equals($class->getId())
            ->count()
            ->getQuery()
            ->execute();
            $class->total = $total;
        }

        $student = [];
        $all_class_equal_age=[];
        $class_query=[];
        $student_nohave_class=[];
        $year_fillter = 0;
        if($id_class !== null){

            $class_query = $doc->getRepository('AppBundle:ClassSchool')->find($id_class);
            $age_class_query = $doc->getRepository('AppBundle:AgeClass')->find($class_query->getageClassId());
            $all_age_class_equal_age =  $doc->getRepository('AppBundle:AgeClass')->findBy(['ageStudent' =>$age_class_query->getageStudent()]);
            $arr_all_age_class_equal_age = [];
            foreach($all_age_class_equal_age as $item){
                array_push($arr_all_age_class_equal_age,$item->getId());
            }
            $all_class_equal_age =  $doc->createQueryBuilder(ClassSchool::class)
            ->field('ageClassId')->all($arr_all_age_class_equal_age)->getQuery()->execute();

            $year_fillter = (int) date("Y") - $age_class_query->getageStudent();
            $date = new \DateTime();
            $date->setDate($year_fillter, 1, 1);
    
            $date2 = new \DateTime();
            $date2->setDate($year_fillter, 12, 31);


        dump($date2);
        dump($date);

            $student_nohave_class = $doc->createQueryBuilder(Student::class)
               ->field('classId')->equals('')
               ->field('birthDay')->lte($date2)
              ->field('birthDay')->gte($date)
              ->getQuery()->execute();
            
            $total_hs_by_age = $doc->getRepository('AppBundle:Student')->findBy(['classId' => $id_class]);
            $student = $doc->getRepository('AppBundle:Student')->findBy(['classId' => $id_class]);
            $status = false;
        }

        // $student_nohave_class = $doc->getRepository('AppBundle:Student')->findBy(['classId' => '']);

        return $this->render('admin/class/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'all_class' => $all_class,
            'student'=> $student,
            'stu_no_class' => $student_nohave_class,
            'class_query' => $class_query,
            'all_class_equal_age' => $all_class_equal_age,
            'year_fillter'=>$year_fillter
        ]);
    }


    /**
     * @Route("/admin/class/addStudent/{id_class}", name="add_student_in_class" , methods={"POST"})
     */
    public function addStudentInClass(Request $request,DocumentManager $doc,$id_class)
    {
        $arr_id_hs = $request->get('arr_id');
        $array = explode(',', $arr_id_hs);
        $update_student = $doc->createQueryBuilder(Student::class)
        ->updateMany()
        ->field('id')->in($array)
        ->field('classId')->set($id_class)
        ->getQuery()
        ->execute();

        return new Response('OK');
    }

     /**
     * @Route("/admin/classChangeClassStudent/changeClassOfStudent", name="change_class_student" , methods={"POST"})
     */
    public function changeClassForStudent(Request $request,DocumentManager $doc)
    {
        $id_student = $request->get('id_student');
        $id_class = $request->get('id_class');
        $doc->createQueryBuilder(Student::class)
        ->updateOne()
        ->field('classId')->set($id_class)
        ->field('id')->equals($id_student)
        ->getQuery()
        ->execute();

        return new Response('OK');
    }




    /**
     * @Route("/admin/class_in_age", name="addNewClass" , methods={"GET","POST"})
     */
    public function store(Request $request,DocumentManager $doc)
    {
        $class = new ClassSchool();
        $ageClass = $doc->getRepository('AppBundle:AgeClass')->findAll();



        $arrChose=[];
        foreach($ageClass as $item){
            $arrChose[$item->getName()] = $item->getId();
        }
        $arrChose['No have age class'] = '0';


        $form = $this->createFormBuilder($class)
        ->add('name', TextType::class,['attr' => ['class' => 'form-control'], 'required' => false])
        ->add('ageClassId', ChoiceType::class,['choices'  => $arrChose,'attr' => ['class' => 'form-control']])
        ->add('save', SubmitType::class, ['label' => 'Add' ,'attr' => ['class' => 'btn btn-success']])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doc->persist($class);
            $doc->flush();         
            return $this->redirectToRoute('age_class');
        }

        return $this->render('admin/class/add.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
        ]);
    }


     /**
     * @Route("/admin/class_in_age/{id}", name="editClass" , methods={"GET","POST"})
     */
    public function update(Request $request,DocumentManager $doc,$id)
    {
        $class = $doc->getRepository('AppBundle:ClassSchool')->find($id);
        
        $ageClass = $doc->getRepository('AppBundle:AgeClass')->findAll();

        $arrChose=[];
        foreach($ageClass as $item){
            $arrChose[$item->getName()] = $item->getId();
        }
        $arrChose['No have age class'] = '0';

        $form = $this->createFormBuilder($class)
        ->add('name', TextType::class,['attr' => ['class' => 'form-control']])
        ->add('ageClassId', ChoiceType::class,['choices'  => $arrChose,'attr' => ['class' => 'form-control']])
        ->add('save', SubmitType::class, ['label' => 'Edit' ,'attr' => ['class' => 'btn btn-success']])
        ->getForm();

        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doc->persist($class);
            $doc->flush();         
            return $this->redirectToRoute('age_class');
        }

        // get teacher no have class
        $teacher_no_class = $doc->getRepository('AppBundle:Teacher')->findBy(['classId' => '']);
        $teacher_of_class = $doc->getRepository('AppBundle:Teacher')->findBy(['classId' => $id]);

        $array_change_teacher = array_merge($teacher_no_class,$teacher_of_class);
          
        dump($array_change_teacher);    

        return $this->render('admin/class/edit.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
            'id' => $class->getId(),
            'array_change_teacher' => $array_change_teacher,
        ]);
    }




     /**
     * @Route("/admin/class/remove/{id}", name="removeClass" , methods={"DELETE"})
     */
    public function removeItem(Request $request,DocumentManager $doc,$id)
    {
       $doc->createQueryBuilder(Student::class)
        ->updateMany()
        ->field('classId')->equals($id)
        ->field('classId')->set('')
        ->getQuery()
        ->execute();

        $class = $doc->getRepository('AppBundle:ClassSchool')->find($id);
        $doc->remove($class);
        $doc->flush();
        return new Response('removed');
    }


     /**
     * @Route("/admin/class/sortteacherclass/{id}", name="sortTeacherInClass" , methods={"POST"})
     */
    public function sortTeacherInClass(Request $request,DocumentManager $doc,$id)
    {
        $class_arr = $request->get('arr_teacher');
        
            $update_all_to_null = $doc->createQueryBuilder(Teacher::class)
            ->updateMany()
            ->field('classId')->equals($id)
            ->field('classId')->set('')
            ->getQuery()
            ->execute();

        if($class_arr !== null){
            $update_id_class_for_teacher = $doc->createQueryBuilder(Teacher::class)
            ->updateMany()
            ->field('id')->in($class_arr)
            ->field('classId')->set($id)
            ->getQuery()
            ->execute();
         }

         $this->addFlash('notice','Update teacher for class');
        return $this->redirectToRoute('editClass',['id'=>$id]);
    }

    
    /**
     * @Route("/admin/search_student_push_in_class", name="search_student_push_in_class" , methods={"POST"})
     */
    public function searchStudentPush(Request $request,DocumentManager $doc)
    {
        $nameSearch = $request->get('nameSearch');
        $emailRegisterSearch = $request->get('emailSearch');
        $year_fillter = $request->get('year_fillterSearch');

        $query = $doc->createQueryBuilder(Student::class)->hydrate(false);
        
        $date = new \DateTime();
        $date->setDate($year_fillter, 1, 1);

        $date2 = new \DateTime();
        $date2->setDate($year_fillter, 12, 31);



        if($nameSearch !== ''){
            $text = new \MongoDB\BSON\Regex($nameSearch);
            $query->field('name')->equals($text);
        }
        if($emailRegisterSearch !== ''){
            $query->field('emailRegister')->equals($emailRegisterSearch);
        }
        $query->field('birthDay')->lte($date2)
        ->field('birthDay')->gte($date);

        
        $value = $query->field('status')->equals(1)
        ->field('classId')->equals('')
        ->getQuery()->toArray();

        dump($value);
       
        return new JsonResponse($value);
    }
}
