<?php


namespace App\Interfaces;


interface BookRepositoryInterface
{
    public function isBookAvailable($id);

    public function getAllAvailable(int $page, int $maxResults);

    public function getBookByType(string $type = null);

}