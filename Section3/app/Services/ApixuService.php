<?php

namespace App\Services;

use App\Models\WeatherStat;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Interfaces\IQueryService;
use Illuminate\Support\Collection;

class ApixuService implements IQueryService
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
            'base_uri' => 'https://api.apixu.com',
        ]);

        foreach ($cities as $city) {
            $response = $guzzleClient->get('v1/current.json', [
                'query' => [
                    'key' => $apiKey,
                    'q' => $city->name
                ]
            ]);
            $response = json_decode($response->getBody()->getContents(), true);

            $stat = new WeatherStat();
            $stat->city()->associate($city);
            $stat->temp_celsius = $response['current']['temp_c'];
            $stat->status = $response['current']['condition']['text'];
            $stat->last_update = Carbon::createFromTimestamp($response['current']['last_updated_epoch']);
            $stat->provider = 'apixu.com';
            $stat->save();

            $result->push($stat);
        }

        return $result;
    }
}