<?php

namespace Codespace\PhpChallenges;

class Weather
{
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Return a undifined object of type StdClass instead of an array
     *
     */
    public function getCurrentWeatherFromLocation(string $location):object
    {
        $url = "http://api.openweathermap.org/data/2.5/weather?q={$location}&appid={$this->apiKey}";

        $response = file_get_contents($url);

        $weatherData = json_decode($response, true);

        $currentWeather = [
            'temperature' => $weatherData['main']['temp'],
            'pressure' => $weatherData['main']['pressure'],
            'humidity' => $weatherData['main']['humidity'],
            'description' => $weatherData['weather'][0]['description'],
        ];

        return (object) $currentWeather;
    }
}

