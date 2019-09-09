<?php
$url = 'http://ja.wikipedia.org/w/api.php?'
.'format=xml&'
.'action=query&'
.'prop=extracts&'
.'rvprop=content&'
.'rvparse&'
.'titles='.urlencode('宇垣美里');
$keyword = '宇垣美里';
$json = file_get_contents("http://wikipedia.simpleapi.net/api?keyword=${keyword}&output=xml");
$xml = simplexml_load_string($json);
if ($xml->result[0]->strict == 1){
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
var_dump((string)$xml);
}
else {
  var_dump("だめだ〜");
}
//https://www.google.com/search?hl=jp&q=%E5%AE%87%E5%9E%A3%E7%BE%8E%E9%87%8C&btnG=Google+Search&tbs=0&safe=off&tbm=isch
