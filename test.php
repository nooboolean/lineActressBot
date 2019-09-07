<?php

$url = 'http://ja.wikipedia.org/w/api.php?'
.'format=xml&'
.'action=query&'
.'prop=extracts&'
.'rvprop=content&'
.'rvparse&'
.'titles='.urlencode('宇垣美里');

$json = file_get_contents("http://wikipedia.simpleapi.net/api?keyword=宇垣美里&output=xml");
$xml = new SimpleXMLElement($json);
$xml = $xml->result[0]->body;
// $arry = json_decode($json);
// $arry = $arry->{"query"}->{"pages"};
// foreach($arry as $arry1){
//   foreach ($arry1 as $key => $value) {
//     if($key == 'extract'){
//       $data = $value;
//       $data = serialize($data);
//       var_dump($data);
//     }
//   }
// }
// $data = serialize($data);
var_dump($xml->asXML());
