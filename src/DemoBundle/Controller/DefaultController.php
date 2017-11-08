<?php

namespace DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class DefaultController
 * @package DemoBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/demo")
     */
    public function indexAction()
    {
        $logger=$this->get('logger');
        $logger->info("test");
        $foo = $this->container->get('service.foo');
        $message=$foo->getHappyMessage();
        return $this->render('DemoBundle:Default:index.html.twig',['message'=>$message]);
    }



}
