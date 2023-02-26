<?php
require_once __DIR__ . "./vendor/autoload.php"; 
 
use voku\helper\HtmlDomParser; 

//https://www.zenrows.com/blog/web-scraping-php#introduction

//http://free-proxy.cz/en/proxylist/country/BR/all/date/all
//https://hidemy.name/en/proxy-checker/

$html = loopPage(
    link: 'https://scrapeme.live/shop/', 
    proxyHost: "177.104.123.30", 
    proxyPort: "5678"
);

set_time_limit(0);

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
    var_dump($highestPaginationNumber);
    die;
    for ($i=1; $i<= (int)$highestPaginationNumber; $i++) {
        $link = $i == 1 ? 'https://scrapeme.live/shop/' : "https://scrapeme.live/shop/page/{$i}/";
        $html = loopPage(link: $link, sleep: rand(1, 5));
        if ($html !== false) {
            $htmlDomParser = HtmlDomParser::str_get_html($html);
            $productElements = $htmlDomParser->find("li.product"); 
            foreach ($productElements as $productElement) { 
                $url = $productElement->findOne("a")->getAttribute("href"); 
                $image = $productElement->findOne("img")->getAttribute("src"); 
                $name = $productElement->findOne("h2")->text; 
                $price = $productElement->findOne(".price span")->text;
                $productData = array( 
                    "url" => $url, 
                    "image" => $image, 
                    "name" => $name, 
                    "price" => $price 
                );
                $productDataList[] = $productData; 
            }
        }
    }
    echo "<pre>";
        print_r($productDataList);
    echo "</pre>";
}

function loopPage($link = null, $sleep = null, $proxyHost = null, $proxyPort = null)
{
    if (!is_null($sleep)) {
        sleep($sleep);
    }
    if (!is_null($link)) {
        $curl = curl_init(); 
        curl_setopt($curl, CURLOPT_URL, $link); 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36");
        
        if (!is_null($proxyHost) && !is_null($proxyPort)) {
            curl_setopt($curl, CURLOPT_PROXY, "{$proxyHost}:{$proxyPort}");
            curl_setopt($curl, CURLOPT_HEADER, 1);
        }
        
        $html = curl_exec($curl); 
        curl_close($curl); 
    }
    return $html ?? false;
}