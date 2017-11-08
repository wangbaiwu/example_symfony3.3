<?php
/**
 * Created by WangQi.
 * All Rights Reserved
 * Time: 11:06
 */
namespace  DemoBundle\Event;
use Symfony\Component\EventDispatcher\Event;


class UserEvent extends Event
{
    public function __construct($conn=null)
    {
        $this->setConn($conn);
    }

    private $conn;
    public function name()
    {
        return "Cartman";
    }

    public function age()
    {
        return "24";
    }

    public function setConn($conn=null)
    {
        $this->conn=$conn;
    }

    public function getConn()
    {
        return $this->conn;
    }

}
