<?php
require_once __DIR__ . '/vendor/autoload.php';
//POST
$input = file_get_contents('php://input');
$json = json_decode($input);
$event = $json->events[0];

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);

//イベントタイプ判別
if ("message" == $event->type) {            //一般的なメッセージ(文字・イメージ・音声・位置情報・スタンプ含む)
    //テキストメッセージにはオウムで返す
    if ("text" == $event->message->type) {
        $keyword = $event->message->text;
        $xml = file_get_contents("http://wikipedia.simpleapi.net/api?keyword=${keyword}&output=xml");
        $xml = simplexml_load_string($xml);
        $output = '';
        if ($xml->result[0]->strict == 1){
          $output = $xml->result[0]->body;
          $output = (string)$output;
        } else {
          $output = 'ちょっと何言ってるかわかんないっす(*´ω｀*)';
        }
        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($output);
    } else {
        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("ごめん、わかんなーい(*´ω｀*)");
    }
} elseif ("follow" == $event->type) {        //お友達追加時
    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("よろしくー");
} elseif ("join" == $event->type) {           //グループに入ったときのイベント
    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('こんにちは よろしくー');
} elseif ('beacon' == $event->type) {         //Beaconイベント
    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('Godanがいんしたお(・∀・) ');
} else {
    //なにもしない
}
$response = $bot->replyMessage($event->replyToken, $textMessageBuilder);
syslog(LOG_EMERG, print_r($event->replyToken, true));
syslog(LOG_EMERG, print_r($response, true));
return;