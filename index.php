<?php
require_once __DIR__ . "./vendor/autoload.php"; 
 
use voku\helper\HtmlDomParser; 
 
$curl = curl_init(); 
curl_setopt($curl, CURLOPT_URL, "https://scrapeme.live/shop/"); 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$html = curl_exec($curl); 
curl_close($curl); 

if ($html !== false) {
    $htmlDomParser = HtmlDomParser::str_get_html($html);
    var_dump($htmlDomParser);
}