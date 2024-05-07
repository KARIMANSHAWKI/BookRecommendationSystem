<?php

namespace App\Domain\Services\Interfaces;

interface IBookService
{
    public function submitUserReadingInterval(array $data);

    public function getMostRecommendedFiveBooks();
}
