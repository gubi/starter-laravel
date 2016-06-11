<?php
namespace Zikkio\Listeners\Subscribers;

abstract class EventSubscriber
{
    /**
     * Event/method mappings
     * @var array
     */
    protected $events = [
    ];
    
    /*
     EXAMPLE
     protected $events = [
        Zikkio\Events\Example::class => "handleExample"
     ];
     public function handleExample(Zikkio\Events\Example $event){ ...handle event... }
     */

    public function subscribe($events){
        foreach ($this->events as $eventClass => $method) {
            $events->listen($eventClass, static::class."@{$method}");
        }
    }
}