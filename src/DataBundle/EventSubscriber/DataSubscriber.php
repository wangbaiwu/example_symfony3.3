<?php
/**
 * Created by WangQi.
 * All Rights Reserved
 * Time: 10:58
 */
namespace DataBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;

class DataSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            "chinese.name" => ["chineseNameShow",100],
        ];
    }

    public function chineseNameShow(Event $event)
    {
        echo "I am data bundle chinese book\n";
    }

}