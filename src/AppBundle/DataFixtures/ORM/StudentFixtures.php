<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Document\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
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


        for ($i = 0; $i < 20; $i++) {
            $date = new \DateTime();
            $date->setDate(2016, rand(1,5), rand(1,8));

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
            $student->setfatherIdcard(rand(100000000000,1000000000000));
            $student->setfatherPhone('03'.rand(100000000,90000000));
            $student->setemailRegister($text[rand(0,9)].$text[rand(0,9)].$text[rand(0,9)].$text[rand(0,9)].$text[rand(0,9)].rand(1000,10000).'@gmail.com');
            $student->setphoneRegister('03'.rand(100000000,90000000));
            $student->setuserId('');
            $student->setStatus(1);
            $student->setClassId('');
            $student->setAvatar($arr_avatar[rand(0.4)]);
            $manager->persist($student);
        }
        $manager->flush();
    }
}
