<?php
include("vendor/autoload.php");
include("TelegramBot.php");
include("Weather.php");

$telegramApi = new TelegramBot;

$weatherApi = new Weather();

while (true) {

    sleep(3);

    $updates = $telegramApi->getUpdates();

    // print_r($updates);
    
    foreach ($updates as $update) {

        if (isset($update->message->location)) {

           $result = $weatherApi->getWeather($update->message->location->latitude, $update->message->location->longitude);

            switch ($result->weather[0]->main) {
                case "Clear":
                $response = "It's sunny outside!";
                break;
                case "Clouds":
                $response = "It's cloudy outside, pick up an umbrella just in case!";
                break;
                case "Rain":
                $response = "It's raining outside, take an umbrella!";
                break;
                default:
                $response = "Look out the window and decide for yourself !!!";
            }

           $telegramApi->sendMessage($update->message->chat->id, $response);

        } else {
            $telegramApi->sendMessage($update->message->chat->id, 'Send your geolocation!');
        }
    }
}
?>