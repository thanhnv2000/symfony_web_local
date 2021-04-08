<?php

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\DocumentManager as DocumentManager;


/**
 * Interface TestInterface.
 *
 * @author Carey Sizer <carey@balanceinternet.com.au>
 */
class TestJob extends Controller
{

    /**
     * @Route("/testsw", name="fixtureHome")
     */
    public function test(DocumentManager $doc){
        $a = $doc->createQueryBuilder(Product::class)
        ->hydrate(false)
        ->getQuery()
        ->toArray();
        dump($a); 
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
