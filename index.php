<?php
require_once __DIR__ . "./vendor/autoload.php"; 
 
use voku\helper\HtmlDomParser; 

//https://www.zenrows.com/blog/web-scraping-php#introduction

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
        $paginationLink = $paginationElement->getAttribute("href"); 
        if (!in_array($paginationLink, $paginationLinks)) { 
            $paginationLinks[] = $paginationLink; 
        } 
    } 
    $highestPaginationNumber = preg_replace("/\D/", "", end($paginationLinks));
    // print the paginationLinks array 
    

    $productElements = $htmlDomParser->find("li.product"); 
    foreach ($productElements as $productElement) { 
        // extract the product data 
        $url = $productElement->findOne("a")->getAttribute("href"); 
        $image = $productElement->findOne("img")->getAttribute("src"); 
        $name = $productElement->findOne("h2")->text; 
        $price = $productElement->findOne(".price span")->text; 
    
        // transform the product data into an associative array 
        $productData = array( 
            "url" => $url, 
            "image" => $image, 
            "name" => $name, 
            "price" => $price 
        ); 
    
        $productDataList[] = $productData; 
    }
    echo "<pre>";
        print_r($productDataList);
        loopPage(sleep:2)
    echo "</pre>";
}


public function loopPage($page = 1, $sleep = 1)
{
    sleep($sleep)
}