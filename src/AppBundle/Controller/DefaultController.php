<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/app", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/app/genuser")
     * @param Request $request
     * @return Response
     */
    public function genUserAction(Request $request)
    {
        $foo=$this->get('service.foo');
        $r=$foo->genUser();
        return new Response($r);
    }

    /**
     * @Route("/app/getuser")
     * @param Request $request
     * @return Response
     */
    public function getUserAction(Request $request)
    {
        $foo=$this->get('service.foo');
        $r=$foo->getUser(1);
        return new Response($r);
    }


}
