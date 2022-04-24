<?php

namespace App\EventListener;

use Symfony\Contracts\EventDispatcher\Event;

class BookCreateEvent extends Event
{
    public const NAME = 'book.created';

    // ....
}