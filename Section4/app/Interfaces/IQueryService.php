<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface IQueryService
{
    /**
     * @param string $apiKey
     * @param Collection $cities
     * @return Collection of City objects
     */
    public function query(string $apiKey, Collection $cities) : Collection;
}