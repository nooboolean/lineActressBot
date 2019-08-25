<?php
DEFINE("ACCESS_TOKEN","dQLkvDlb84bZwwxGovklsbNSizODCximzaLmOrYuVZ+nPPBn0YdrAFDEAdpu/QJNjrdUC72OTqXN7EaCilQQBidTfp+5JeJSXVGv19AaUeD60eGH/fPV8J5Mnkh3QE2dv2C68xKyfDRZe/0hZgaUrwdB04t89/1O/w1cDnyilFU=");
DEFINE("SECRET_TOKEN","c80619da86ed696ddc27a0876af8b2d0");

use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use \LINE\LINEBot\Constant\HTTPHeader;

//LINESDKの読み込み
require_once(__DIR__."/vendor/autoload.php");

//LINEから送られてきたらtrueになる
if(isset($_SERVER["HTTP_".HTTPHeader::LINE_SIGNATURE])){

//LINEBOTにPOSTで送られてきた生データの取得
  $inputData = file_get_contents("php://input");

//LINEBOTSDKの設定
  $httpClient = new CurlHTTPClient(ACCESS_TOKEN);
  $bot = new LINEBot($HttpClient, ['channelSecret' => SECRET_TOKEN]);
  $signature = $_SERVER["HTTP_".HTTPHeader::LINE_SIGNATURE]; 
  $Events = $bot->parseEventRequest($inputData, $signature);

//大量にメッセージが送られると複数分のデータが同時に送られてくるため、foreachをしている。
  foreach($Events as $event){
    $SendMessage = new MultiMessageBuilder();
    $TextMessageBuilder = new TextMessageBuilder("よろぽん！");
    $SendMessage->add($TextMessageBuilder);
    $bot->replyMessage($event->getReplyToken(), $SendMessage);
  }
  echo '成功';
}
echo '失敗';