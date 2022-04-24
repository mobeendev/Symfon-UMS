<?php

namespace App\EventListener;

use App\EventListener\BookCreateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class BookEventSubscriber implements EventSubscriberInterface
{
    // Returns an array indexed by event name and value by method name to call
    public static function getSubscribedEvents()
    {
        return [
            BookCreateEvent::NAME => 'onBookCreation',
            //hook multiple functions with the events with priority for sequence of function calls
            // ProductUpdateEvent::NAME => [
            //     ['onProductCreation', 1],
            //     ['onProductUpdation', 2],
            // ],
            // ProductDeleteEvent::NAME => 'onProductDeletion',
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }

    public function onBookCreation(BookCreateEvent $event)
    {   dump('creating booking in progress' , $event);
        // write code to execute on product creation event
    }


    public function onKernelResponse(ResponseEvent  $event)
    {
        // write code to execute on in-built Kernel Response event
    }
}