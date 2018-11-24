<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\WeatherStat;
use App\Interfaces\IQueryService;
use Illuminate\Support\Collection;

class OpenWeatherMapService implements IQueryService
{
    /**
     * @param string $apiKey
     * @param Collection $cities
     * @return Collection of City objects
     */
    public function query(string $apiKey, Collection $cities): Collection
    {
        $result = collect();

        $guzzleClient = new Client([
            'base_uri' => 'https://api.openweathermap.org',
        ]);

        foreach ($cities as $city) {
            $response = $guzzleClient->get('data/2.5/weather', [
                'query' => [
                    'units' => 'metric',
                    'APPID' => $apiKey,
                    'q' => $city->name
                ]
            ]);
            $response = json_decode($response->getBody()->getContents(), true);

            // https://openweathermap.org/weather-data#current
            $stat = new WeatherStat();
            $stat->city()->associate($city);
            $stat->temp_celsius = $response['main']['temp'];
            $stat->status = $response['weather'][0] ?
                $response['weather'][0]['main'] : '';
            $stat->last_update = Carbon::createFromTimestamp($response['dt']); // 	Data receiving time
            $stat->provider = 'openweathermap.org';
            $stat->save();

            $result->push($stat);
        }

        return $result;
    }
}