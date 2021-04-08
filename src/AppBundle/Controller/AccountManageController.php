<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use AppBundle\Document\User;
use AppBundle\Document\Student;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AccountManageController extends Controller
{
    /**
     * @Route("/admin/account", name="adminAccount")
     */
    public function index(Request $request,DocumentManager $doc)
    {
        $type = $request->get('type');
        if($type == 'teacher' || $type == null){
            $data = $doc->getRepository('AppBundle:User')->findBy(['roles' => ["ROLE_TEACHER"],'status' => 1]);
        }else if($type == 'student'){
            $data = $doc->getRepository('AppBundle:User')->findBy(['roles' => ["ROLE_STUDENT"],'status' => 1]);
        }
        return $this->render('admin/account/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'data' => $data,
            'type' => $type
        ]);
    }

     



    /**
     * @Route("/admin/account/search", name="searchAccount" , methods={"POST"})
     */
    public function searchIndex(Request $request,DocumentManager $doc)
    {

        $name = $request->get('nameSearch');
        $username= $request->get('userNameSearch');
        $status= $request->get('statusSearch');
        $type_string = $request->get('typeSearch');
        $role = ['ROLE_TEACHER'];
        if($type_string == 'student'){
            $role = ['ROLE_STUDENT'];
        }
        $array_find =[];
        if($name !== ''){
            $array_find['name'] = $name;
        }
        if($username !== ''){
            $array_find['username'] = $username;
        }
        if($status !== ''){
            $array_find['status'] = $status;
        }


        $array_find['roles'] = $role;

        $data = $doc->getRepository('AppBundle:User')->findBy($array_find);
      
        return $this->render('admin/account/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'data' => $data,
            'type' => $type_string
        ]);
    }


    /**
     * @Route("/admin/account/{id}", name="showAccount" , methods={"GET","POST"})
     */
    public function show(Request $request,DocumentManager $doc,$id)
    {
        $account = $doc->getRepository('AppBundle:User')->find($id);

        $form = $this->createFormBuilder($account)
        ->add('status', ChoiceType::class,['choices'  => [
            'Active' => 1,
            'Unactive' => 0,
            ],
            'attr' => ['class' => 'form-control form-control-sm']]
        )
        ->add('save', SubmitType::class, ['label' => 'Change status' ,'attr' => ['class' => 'btn-sm btn-success ']])
        ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $doc->persist($account);
            $doc->flush();         
            return $this->redirectToRoute('adminAccount');
        }

        $role_show = implode(',',$account->getRoles());
        return $this->render('admin/account/show.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'form' => $form->createView(),
            'info' => $account,
            'role_show' => $role_show
        ]);
    }
    

        /**
     * @Route("/admin/accountStudentMerge", name="accountMergeStudent" , methods={"POST"})
     */
    public function accountMergeStudent(Request $request,DocumentManager $doc)
    {
        $key_account = $request->get('key_account');
        $string_account_merge = $request->get('arr_account_merge');
        $change_to_array = explode(',', $string_account_merge);

        $arr_check = [];
        foreach($change_to_array as $item){
            if($item !== $key_account){
                array_push($arr_check,$item);
            }
        }
        // change all user have userId in arr_account to key_account
        $doc->createQueryBuilder(Student::class)
        ->updateMany()
        ->field('userId')->in($arr_check)
        ->field('userId')->set($key_account)
        ->getQuery()
        ->execute();
        // change arr_user to status 0 -> disable account
        $doc->createQueryBuilder(User::class)
        ->updateMany()
        ->field('id')->in($arr_check)
        ->field('status')->set(0)
        ->getQuery()
        ->execute();

        return $this->redirectToRoute('adminAccount');
     
    }



}
