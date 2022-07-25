<?php


namespace App\Interfaces;


interface BookRepositoryInterface
{
    public function isBookAvailable($id);

    public function getAllAvailable();

    public function getBookByType(string $type = null);

}