<?php

$url = 'http://ja.wikipedia.org/w/api.php?'
.'format=json&'
.'action=query&'
.'prop=extracts&'
.'rvprop=content&'
.'rvparse&'
.'titles='.urlencode('宇垣美里');

$json = file_get_contents($url);
$arry = json_decode($json);
$data = $arry;
var_dump($data->{"query"});
