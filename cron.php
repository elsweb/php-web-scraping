<?php
require_once __DIR__ . "./vendor/autoload.php"; 
 
use voku\helper\HtmlDomParser; 

$cron = 'aliexpress';

switch ($cron) {
    case 'aliexpress':
        // $id = '1005005133738841';
        // $link = "https://pt.aliexpress.com/item/{$id}.html";
        // $html = aliScrap(link:$link);
        // $search = '.product-price-value';
        // $htmlDomParser = HtmlDomParser::str_get_html($html);
        // var_dump($htmlDomParser->findOne('totalValue'));
        getDataAli();
        break;
    
    default:
        # code...
        break;
}

function aliScrap($link, $cron = 'single') {
    switch ($cron) {
        case 'single':
            return getData($link);
            break;
        
        default:
            # code...
            break;
    }
}

function getData($link) {
    
    $curl = curl_init(); 
    curl_setopt($curl, CURLOPT_URL, $link); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36");
    $html = curl_exec($curl); 
    curl_close($curl); 

    return $html;
}
function getDataAli() {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'http://gw.api.taobao.com/router/rest');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "app_key=12129701&format=json&method=aliexpress.solution.product.info.get&partner_id=apidoc&session=4535467e-5014-4a3b-9786-a64c4c47bdbb&sign=B8DE4A759F781F6B9AA875ED60432F6F&sign_method=hmac&timestamp=2023-03-13+02%3A33%3A24&v=2.0&product_id=1307422965");

    $headers = array();
    $headers[] = 'Content-Type: application/x-www-form-urlencoded;charset=utf-8';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    var_dump($result);
}