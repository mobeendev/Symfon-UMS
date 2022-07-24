<?php


namespace App\Interfaces;


use App\Entity\Book;
use App\Entity\User;

interface BookingRequestRepositoryInterface
{
    public function isBookAvailable(Book $book, User $user);
}