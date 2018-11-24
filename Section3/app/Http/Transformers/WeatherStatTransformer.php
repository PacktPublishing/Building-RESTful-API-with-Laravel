<?php

namespace App\Http\Transformers;

use App\Models\WeatherStat;
use League\Fractal\TransformerAbstract;

class WeatherStatTransformer extends TransformerAbstract
{
    public function transform(WeatherStat $weatherStat)
    {
        return [
            'id' => $weatherStat->id,
            'city_id' => $weatherStat->city_id,
            'city_name' => $weatherStat->city->name,
            'temp_celsius' => $weatherStat->temp_celsius,
            'status' => $weatherStat->status,
            'measurement_time' => $weatherStat->last_update,
            'provider' => $weatherStat->provider,
            'created_at' => $weatherStat->created_at,
        ];
    }
}
