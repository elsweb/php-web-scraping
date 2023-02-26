<?php
require_once __DIR__ . "./vendor/autoload.php"; 
 
use voku\helper\HtmlDomParser; 
 
$curl = curl_init(); 
curl_setopt($curl, CURLOPT_URL, "https://scrapeme.live/shop/"); 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
$html = curl_exec($curl); 
curl_close($curl); 

var_dump($html);
 
// initialize HtmlDomParser 
$htmlDomParser = HtmlDomParser::str_get_html('<b>a</b>');
// var_dump($htmlDomParser);