<?php
use GuzzleHttp\Client;

class Weather{

    protected $token = "f6b50a57e36a5ae6d136e8fbc2176b47";

    public function getWeather($lat, $lon) {

        $url = "api.openweathermap.org/data/2.5/weather";

        $params = [];
        $params['lat'] = $lat;
        $params['lon'] = $lon;
        $params['APPID'] = $this->token;

        $url .= "?" . http_build_query($params);

        $client = new Client([
            'base_uri' => $url
        ]);

        $result = $client->request('GET');

        return json_decode($result->getBody());
    }
}
?>