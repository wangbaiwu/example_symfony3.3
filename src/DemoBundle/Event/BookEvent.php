<?php
/**
 * Created by WangQi.
 * All Rights Reserved
 * Time: 10:49
 */
namespace DemoBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class BookEvent extends Event
{
    public $name = self::class;
}