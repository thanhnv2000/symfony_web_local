<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Document\Student;
use AppBundle\Document\StudentApply;
use AppBundle\Document\Teacher;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;

class FixtureController extends Controller
{
    /**
     * @Route("/fixtrue", name="fixtureHome")
     */
    public function index(Request $request,DocumentManager $doc)
    {

        $this->fixtureStudent($doc);
        $this->fixtureTeacher($doc);
        $this->fixtureStudentApply($doc);
        
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    public function fixtureStudent(DocumentManager $doc){
        $ho = array("Hoa","Thien Nhuan","Ngoc","Bi Bi","Duong","Tra","Nha","Tran",'Ky');
        $ten_boy = array("Tam","Ly","Hung","Thien","Tam","Ngoc","Long","Toan","Xuan");
        $ten_girl = array("Ngoc","Linh","Tuyet","Xuan","Dong","Huyen","Thanh",'Hue','Hoa','Bich');

        $text = array("a","b","c","d","f","g","h","e","c","t","k","l","w","q","r");
        $arr_avatar=[
            '4a550da4e8f6d6501c99cb8b2a885745.jpeg',
            '6d23c010368cdd2c1dbaf683710c98a8.jpeg',
            '7e04f484325451f61ac98fb2ded446b7.jpeg',
            '57a31931250fcc1935d0eaf7743fc91d.jpeg',
            '9886cc8b2d643fc9662cadbc5f3976f2.jpeg',
            'df077c6cc77d7bfbdf0e9c33a1afd94a.jpeg'
        ];

        for ($i = 0; $i < 35; $i++) {
            $date = new \DateTime();

            $date->setDate(2019, rand(1,5), rand(1,8));
            if($i < 7){
                $date->setDate(2017, rand(1,5), rand(1,8));
            }else if($i >=7 && $i <= 15){
                $date->setDate(2018, rand(1,5), rand(1,8));
            }else if($i >=16 && $i <= 23){
                $date->setDate(2019, rand(1,5), rand(1,8));
            }else if($i >=24 && $i <= 35){
                $date->setDate(2020, rand(1,5), rand(1,8));
            }

            $student = new Student();
            $student->setName('student_'.$i);
            $student->setGender(rand(0,1));
            $student->setbirthDay($date);
            $student->setNation('Kinh');
            $student->setdayAdmission($date);
            $student->setfatherName($ho[rand(0,8)].' '.$ten_boy[rand(0,8)]);
            $student->setfatherIdcard(rand(100000000000,1000000000000));
            $student->setfatherPhone('03'.rand(100000000,90000000));
            $student->setmotherName($ho[rand(0,8)].' '.$ten_girl[rand(0,8)]);
            $student->setmotherIdcard(rand(100000000000,1000000000000));
            $student->setmotherPhone('03'.rand(100000000,90000000));
            $student->setemailRegister($text[rand(0,9)].$text[rand(0,9)].$text[rand(0,9)].$text[rand(0,9)].$text[rand(0,9)].rand(1000,10000).'@gmail.com');
            $student->setphoneRegister('03'.rand(100000000,90000000));
            $student->setuserId('');
            $student->setStatus(1);
            $student->setClassId('');
            $student->setAvatar($arr_avatar[rand(0,4)]);
            $doc->persist($student);
        }
        $doc->flush();
    }

    public function fixtureTeacher(DocumentManager $doc){
        $ho = array("Hoa","Thien Nhuan","Ngoc","Bi Bi","Duong","Tra","Nha","Tran",'Ky');
        $ten = array("Tam","Ly","Hung","Thien","Tam","Ngoc","Long","Toan","Xuan","Ngoc","Linh","Tuyet","Xuan","Dong","Huyen","Thanh",'Hue','Hoa','Bich');

        $text = array("a","b","c","d","f","g","h","e","c","t","k","l","w","q","r");
        $arr_avatar=[
            '4a550da4e8f6d6501c99cb8b2a885745.jpeg',
            '6d23c010368cdd2c1dbaf683710c98a8.jpeg',
            '7e04f484325451f61ac98fb2ded446b7.jpeg',
            '57a31931250fcc1935d0eaf7743fc91d.jpeg',
            '9886cc8b2d643fc9662cadbc5f3976f2.jpeg',
            'df077c6cc77d7bfbdf0e9c33a1afd94a.jpeg'
        ];

        for ($i = 0; $i < 20; $i++) {
            $date = new \DateTime();
            $date->setDate(2016, rand(1,5), rand(1,8));

            $teacher = new Teacher();
            $teacher->setName($ho[rand(0,8)].' '.$ten[rand(0,16)]);
            $teacher->setCodeTeacher('PT'.rand(10000,100000));
            $teacher->setbirthDay($date);
            $teacher->setIdCard(rand(100000000000,1000000000000));
            $teacher->setPhone('03'.rand(100000000,90000000));
            $teacher->setEmail($text[rand(0,9)].$text[rand(0,9)].$text[rand(0,9)].$text[rand(0,9)].$text[rand(0,9)].rand(1000,10000).'@gmail.com');
            $teacher->seteducatePlace('University');
            $teacher->setAddress('NewWord');
            $teacher->setClassId('');
            $teacher->setUserId('');
            $teacher->setAvatar($arr_avatar[rand(0,4)]);
            $doc->persist($teacher);
        }
        $doc->flush();
    }

    public function fixtureStudentApply(DocumentManager $doc){
        $ho = array("Hoa","Thien Nhuan","Ngoc","Bi Bi","Duong","Tra","Nha","Tran",'Ky');
        $ten_boy = array("Tam","Ly","Hung","Thien","Tam","Ngoc","Long","Toan","Xuan");
        $ten_girl = array("Ngoc","Linh","Tuyet","Xuan","Dong","Huyen","Thanh",'Hue','Hoa','Bich');

        $text = array("a","b","c","d","f","g","h","e","c","t","k","l","w","q","r");
        $arr_avatar=[
            '4a550da4e8f6d6501c99cb8b2a885745.jpeg',
            '6d23c010368cdd2c1dbaf683710c98a8.jpeg',
            '7e04f484325451f61ac98fb2ded446b7.jpeg',
            '57a31931250fcc1935d0eaf7743fc91d.jpeg',
            '9886cc8b2d643fc9662cadbc5f3976f2.jpeg',
            'df077c6cc77d7bfbdf0e9c33a1afd94a.jpeg'
        ];

        for ($i = 0; $i < 35; $i++) {
            $date = new \DateTime();
            $date->setDate(2019, rand(1,5), rand(1,8));
            if($i < 7){
                $date->setDate(2017, rand(1,5), rand(1,8));
            }else if($i >=7 && $i <= 15){
                $date->setDate(2018, rand(1,5), rand(1,8));
            }else if($i >=16 && $i <= 23){
                $date->setDate(2019, rand(1,5), rand(1,8));
            }else if($i >=24 && $i <= 35){
                $date->setDate(2020, rand(1,5), rand(1,8));
            }

            $student = new StudentApply();
            $student->setName('student_'.$i);
            $student->setGender(rand(0,1));
            $student->setbirthDay($date);
            $student->setNation('Kinh');
            $student->setfatherName($ho[rand(0,8)].' '.$ten_boy[rand(0,8)]);
            $student->setfatherIdcard(rand(100000000000,1000000000000));
            $student->setfatherPhone('03'.rand(100000000,90000000));
            $student->setmotherName($ho[rand(0,8)].' '.$ten_girl[rand(0,8)]);
            $student->setmotherIdcard(rand(100000000000,1000000000000));
            $student->setmotherPhone('03'.rand(100000000,90000000));
            $student->setemailRegister($text[rand(0,9)].$text[rand(0,9)].$text[rand(0,9)].$text[rand(0,9)].$text[rand(0,9)].rand(1000,10000).'@gmail.com');
            $student->setphoneRegister('03'.rand(100000000,90000000));
            $student->setStatus(1);
            $student->setcodeForm('fsaf'.rand(10000000000,9900000000000));
            $student->setAvatar($arr_avatar[rand(0,4)]);
            $doc->persist($student);
        }
        $doc->flush();
    }


}
