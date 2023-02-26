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
    $paginationElements = $htmlDomParser->find(".page-numbers a"); 
    $paginationLinks = []; 
    foreach ($paginationElements as $paginationElement) { 
        // populate the paginationLinks set with the URL 
        // extracted from the href attribute of the HTML pagination element 
        $paginationLink = $paginationElement->getAttribute("href"); 
        // avoid duplicates in the list of URLs 
        if (!in_array($paginationLink, $paginationLinks)) { 
            $paginationLinks[] = $paginationLink; 
        } 
    } 
     
    // print the paginationLinks array 
    print_r($paginationLinks);
}