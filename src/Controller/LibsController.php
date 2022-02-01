<?php
namespace ICS\LibsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LibsController extends AbstractController
{

    /**
    * @Route("/",name="ics-libs-homepage")
    */
    public function index()
    {

        return $this->render('@Libs\index.html.twig',[]);
    }

}