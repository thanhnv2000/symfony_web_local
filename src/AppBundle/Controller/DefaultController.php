<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Document\AgeClass;
use AppBundle\Document\Product;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use AppBundle\Controller\TestInterface;
use Doctrine\ODM\MongoDB\Events;
use AppBundle\Controller\ClassController;
use DateTime;
use AppBundle\Event\TestEvent;
use Knp\Component\Pager\Event\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
class DefaultController extends Controller  
{

    /**
     * @Route("/default", name="homepage")
     */
    public function indexAction(Request $request,DocumentManager $doc,?TestInterface $test,EventDispatcherInterface $eventDispatcher)
    {


       

        // $class = new Product();
        // $class->setName('435432s');
        // $class->setCreated_at($date);
        // $doc->persist($class);
        // $doc->flush();
        
        // $eventDispatcher->dispatch(TestEvent::NAME);

        // dump($dispatch);
        // $date = new DateTime();
        // $date->setDate(2021,1,20);

        // $date2 = new DateTime();
        // $date2->setDate(2021,10,10);


        // $currentDateTime = new \DateTime('now', new \DateTimeZone('UTC'));
        // $hour = $currentDateTime->format('H:i');
        // $currentday = $currentDateTime->format('H:i');

        // $interval = new \DateInterval('P10D');
      
        // $backDate1day = $currentDateTime->sub($interval);
        // dump($currentDateTime);
        // dump($backDate1day);




        // $currentDateTime->format('H:i');

        // $repository = $doc->createQueryBuilder(Product::class)
        // ->findAndRemove()
        // ->field('created_at')->gte($date)
        // ->field('created_at')->lte($date2)
        // ->getQuery()
        // ->execute();


        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
