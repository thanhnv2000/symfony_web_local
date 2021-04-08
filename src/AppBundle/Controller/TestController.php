<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Document\Author;
use AppBundle\Document\Product;
use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;
use AppBundle\Controller\DocumentIterator as DocumentIterator;
class TestController extends Controller
{
    /**
     * @Route("/test", name="testpage")
     */
    public function indexAction(Request $request,DocumentManager $doc)
    {
        // replace this example code with whatever you need

        $a = $doc->createQueryBuilder('AppBundle\Document\Product')
        ->hydrate(false)
        ->getQuery()
        ->toArray();
        
        dump($a); 
        
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
