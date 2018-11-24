<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\City;
use InvalidArgumentException;
use App\Http\Transformers\WeatherStatTransformer;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QueryController extends Controller
{
    public function current($city) {
        if(!($city = City::where('name', $city)->first()))
            throw new NotFoundHttpException('Unknown city!');


        return $this->response->item($city->weatherStats()->first() ?? collect(), new WeatherStatTransformer());
    }

    public function all($city) {
        if(!($city = City::where('name', $city)->first()))
            throw new NotFoundHttpException('Unknown city!');

        return $this->response->collection($city->weatherStats, new WeatherStatTransformer());
    }

    public function date($city, $date) {
        if(!($city = City::where('name', $city)->first()))
            throw new NotFoundHttpException('Unknown city!');

        try {
            $date = Carbon::createFromFormat('YYYY-MM-DD', $date);
        } catch (InvalidArgumentException $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }

        $stats = $city->weatherStats()
            ->whereBetween('last_updated', [
                $date->startOfDay(),
                $date->endOfDay()
            ])
            ->get();

        return $this->response->collection($stats, new WeatherStatTransformer());
    }
}
