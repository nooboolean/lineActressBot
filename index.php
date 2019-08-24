<?php
    // Composerでインストールしたライブラリを一括読み込み
    require_once __DIR__ . '/vendor/autoload.php';

    // アクセストークンを使いCurlHTTPClientをインスタンス化
    $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('Hwb00gSaNTRwf0a81xZiigOQfMc8MEZGB26eGjQ5kw9b9iDOdmVjMH8TTBbt2WSQjrdUC72OTqXN7EaCilQQBidTfp+5JeJSXVGv19AaUeChDlHxBXzEuxsnnpZVtgRbCijOKPiCLRgWcHuH6NNFiwdB04t89/1O/w1cDnyilFU=');

    //CurlHTTPClientとシークレットを使いLINEBotをインスタンス化
    $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '6fd46cbd83f2d4a7ceb364085447663a']);

    // LINE Messaging APIがリクエストに付与した署名を取得
    $signature = $_SERVER["HTTP_" . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

    //署名をチェックし、正当であればリクエストをパースし配列へ、不正であれば例外処理
    $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);

    foreach ($events as $event) {
        // メッセージを返信
        $response = $bot->replyMessage(
            $event->getReplyToken(), new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($event->getText())  
        );
    }