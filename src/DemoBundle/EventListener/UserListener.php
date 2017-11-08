<?php
/**
 * Created by WangQi.
 * All Rights Reserved
 * Time: 9:42
 */
namespace DemoBundle\EventListener;
use Symfony\Component\EventDispatcher\Event;

class UserListener
{


    public function onNameAction(Event $event)
    {
        $conn=$event->getConn();
        $row=$conn->fetchColumn("select name from user where id=:id",["id"=>1]);
        echo "My name is ".$event->name()." DB: ".$row."\n";

    }
}