<?php
/**
 * Created by WangQi.
 * All Rights Reserved
 * Time: 10:46
 */
namespace DemoBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;

class BookSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            "chinese.name" => "chineseNameShow",
            "english.name" => [
                ["englishNameShow", -10],
                ["englishNameAFter", 10],
            ],
            "math.name" => ["mathNameShow", 100]
        ];
    }

    public function chineseNameShow(Event $event)
    {
        echo "我是汉语书籍\n";
    }

    public function englishNameShow(Event $event)
    {
        echo "我是英文书籍\n";
    }

    public function englishNameAFter(Event $event)
    {
        echo "我是展示之后的英文书籍[来自于Event实例{$event->name}]\n";
    }

    public function mathNameShow(Event $event)
    {
        echo "我是展示的数学书籍\n";
    }
}