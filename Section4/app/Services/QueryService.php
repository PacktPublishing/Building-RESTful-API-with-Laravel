<?php

namespace App\Services;

use App\Models\City;

class QueryService
{
    protected $openWeatherMapService;
    protected $apixuService;

    public function __construct(
        OpenWeatherMapService $openWeatherMapService,
        ApixuService $apixuService
    ) {
        $this->openWeatherMapService = $openWeatherMapService;
        $this->apixuService = $apixuService;
    }

    public function queryAll()
    {
        $cities = City::all();
        $this->openWeatherMapService->query(env('OPENWEATHERMAP_APIKEY'), $cities);
        $this->apixuService->query(env('APIXU_APIKEY'), $cities);
    }
}