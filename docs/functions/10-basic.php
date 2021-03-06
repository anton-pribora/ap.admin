<?php

function Html($html) {
    return htmlentities($html, ENT_QUOTES, 'utf-8');
}

function HtmlAndBr($html) {
    return nl2br(htmlentities($html, ENT_QUOTES, 'utf-8'));
}

function json_encode_array($data) {
    return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR);
}

function json_encode_array_pretty_print($data) {
    return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR | JSON_PRETTY_PRINT);
}

function json_decode_array($data) {
    return json_decode($data, true);
}

function activateUrls($text, $maxLen = 40) {
    $re = [
        '(https?://[^\s)]+)',
        '(\w[\w.-]*@[\w.-]*\w)',
        '((?:\+?\d\D?\D?\d\d\d\D?\D?\d\d\d\D?\d\d\D?\d\d)|(?:\+?\d\D?\D?\d\d\d\D?\D?\d\d\D?\d\d\d\D?\d\d)|(?:\+?\d\D?\D?\d\d\d\D?\D?\d\d\D?\d\d\D?\d\d\d))',
    ];
    
    $va = preg_split('~'. join('|', $re) .'~ui',$text, -1, PREG_SPLIT_DELIM_CAPTURE);
    
    $k = -1;
    $result = [];
    
    foreach ($va as $i => $chunk) {
        if ($chunk === '') {
            ++$k;
            continue;
        }
        
        switch ($k) {
            case 0:
                $text = $maxLen ? mb_strimwidth($chunk, 0, $maxLen, '&hellip;') : $chunk;
                $result[] = '<a href="'. Html($chunk) .'" target="_blank" title="'. Html($chunk) .'">'. Html($text) .'</a>';
                $k = -1;
                break;
                
            case 1:
                $text = $maxLen ? mb_strimwidth($chunk, 0, $maxLen, '&hellip;') : $chunk;
                $result[] = '<a href="mailto:'. Html($chunk) .'" title="mailto:'. Html($chunk) .'">'. Html($text) .'</a>';
                $k = -1;
                break;
                
            case 2:
                $tel  = preg_replace(['/[^\d+]/', '/^\+?[78]/'], ['', '+7'], $chunk);
                $text = $maxLen ? mb_strimwidth($chunk, 0, $maxLen, '&hellip;') : $chunk;
                
                $result[] = "<a href=\"tel:$tel\" title=\"tel:$tel\">$text</a>";
                $k = -1;
                break;
                
            default:
                $k = 0;
                $result[] = $chunk;
                break;
        }
    }
    
    return join($result);
}