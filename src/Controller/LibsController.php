<?php

namespace ICS\LibsBundle\Controller;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use ICS\SsiBundle\Entity\Account;
use Doctrine\ORM\EntityManagerInterface;

class LibsController extends AbstractController
{
    /**
     * @Route("/",name="ics-libs-homepage")
     */
    public function index()
    {

        return $this->render('@Libs\index.html.twig', []);
    }

    /**
     * @Route("/theme/select/{theme}",name="ics-libs-select-theme")
     */
    public function selectTheme(Security $security, EntityManagerInterface $em ,$theme=null)
    {
        if($theme=='default')
        {
            $theme=null;
        }
        $user = $security->getUser();
        if(is_a($user,Account::class))
        {
            $user->getProfile()->setParameter('theme', $theme);
            $em->persist($user);
            $em->flush();
            dump($user);
        }

        return new Response('Ok');
    }

    /**
     * @Route("/fonts/{font}", name="ics-fonts-css")
     */
    public function fonts(KernelInterface $kernel, $font)
    {
        $fontsPath = $kernel->getProjectDir() . '/public/bundles/libs/local/fonts';

        if (!file_exists($fontsPath . '/' . $font)) {
            return new NotFoundHttpException('Non existent Font.');
        }

        $fontPath= $fontsPath.'/'.$font;

        $dir = opendir($fontPath);
        while ($file = readdir($dir)) {
            if($file!= '.' && $file != '..')
            {
                $files[] = $fontPath.'/'.$file;
            }
        }
        
        return new Response('<html><body></body></html>');
    }
}
