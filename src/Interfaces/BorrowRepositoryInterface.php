<?php


namespace App\Interfaces;


use App\Entity\Book;
use App\Entity\User;

interface BorrowRepositoryInterface
{
    public function isBookAvailable(Book $book, User $user);
}