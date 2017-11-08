<?php
/**
 * Created by WangQi.
 * All Rights Reserved
 * Time: 10:34
 */

namespace ServiceBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use DataBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class Foo extends Controller
{
    /** @var \Symfony\Component\DependencyInjection\Container  */
    protected $container;

    /**
     * Foo constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container=$container;
    }

    /**
     * @return mixed
     */
    public function getHappyMessage()
    {
        $messages = [
            'You did it! You updated the system! Amazing!',
            'That was one of the coolest updates I\'ve seen all day!',
            'Great work! Keep going!',
        ];

        $index = array_rand($messages);

        return $messages[$index];
    }

    /**
     * @param int $userId
     * @return mixed
     */
    public function getUser($userId=0)
    {
        $user=$this->getDoctrine()->getRepository(User::class)->find($userId);
        return $user->getName();
    }

    /**
     * @return int
     */
    public function genUser()
    {
        $em=$this->getDoctrine()->getManager();
        $user=new User();
        $user->setName('admin');
        $user->setPassword('bbb');
        $user->setEmail('a@a.com');
        $user->setGenTime(new \DateTime());
        $em->persist($user);
        $em->flush();
        return $user->getId();
    }


}


