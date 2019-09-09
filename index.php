<?php
require_once __DIR__ . '/vendor/autoload.php';
//POST
$input       = file_get_contents('php://input');
$json        = json_decode($input);
$event       = $json->events[0];
$reply_count = 0;

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);

if ($event->type == "message") {
  if ($event->message->type == "text") {
      if (preg_match('/変態メガネ/', $received_message)){
        $output = '調べて欲しい女優の名前を言ってみたまえ';
      } else {
        $received_message = $event->message->text;
      $xml = file_get_contents("http://wikipedia.simpleapi.net/api?keyword=${received_message}&output=xml");
      $xml = simplexml_load_string($xml);
      $output = '';
      if ($xml->result[0]->strict == 1){
        $output = $xml->result[0]->body;
        $output = (string)$output;
      } else {
        $output = 'ちょっと何言ってるかわかんないっす(*´ω｀*)';
      }
    }
  }
}
$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($output);
$response = $bot->replyMessage($event->replyToken, $textMessageBuilder);
syslog(LOG_EMERG, print_r($event->replyToken, true));
syslog(LOG_EMERG, print_r($response, true));
return;