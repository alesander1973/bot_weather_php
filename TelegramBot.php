<?php
use GuzzleHttp\Client;

class TelegramBot
{
    protected $token = "716691239:AAEvq-sF5XB_LwJ4lu9DhljXJAaqLD7w0g4";

    protected $updateId;

    protected function query($method, $params=[])
    {
     
        $url = "https://api.telegram.org/bot";

        $url .= $this->token;

        $url .= "/" . $method;

        if (!empty($params)) {
            $url .= "?" . http_build_query($params);
        }

        $client = new Client([
            'base_uri' => $url,
            'timeout'  => 2.0,
        ]);
        $result = $client->request('GET');  

        return json_decode($result->getBody());
    }

    public function getUpdates()
    {
        $response = $this->query('getUpdates', [
            'offset'=> $this->updateId + 1
        ]);

        if (!empty($response->result)) {

            $this->updateId = $response->result[count($response->result) - 1]->update_id;
        }

        return $response->result;
    }
  
    public function sendMessage($chat_id,$text)
    {
        $response = $this->query('sendMessage',[
            'text' => $text,
            'chat_id' => $chat_id
        ]);
        return $response;
    }
}
?>