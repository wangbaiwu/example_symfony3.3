<?php

namespace ServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ServiceBundle\Service\Foo;

class DefaultController extends Controller
{
    /**
     * @Route("/service")
     */
    public function indexAction()
    {
//        $foo = $this->get(Foo::class);
//        $message=$foo->getHappyMessage();
        $foo=$this->container->get('service.foo');
        $message=$foo->getHappyMessage();

        return $this->render('ServiceBundle:Default:index.html.twig',['message'=>$message]);
    }
}
