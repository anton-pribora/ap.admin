<?php

function Html($html) {
    return htmlentities((string) $html, ENT_QUOTES | ENT_SUBSTITUTE, 'utf-8');
}

function HtmlAndBr($html) {
    return nl2br(htmlentities($html, ENT_QUOTES | ENT_SUBSTITUTE, 'utf-8'));
}

function json_encode_array($data) {
    return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR);
}

function json_encode_array_pretty_print($data) {
    return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR | JSON_PRETTY_PRINT);
}

function json_decode_array($data) {
    if (is_null($data)) {
        return null;
    }

    return json_decode($data, true);
}

function set_request_extra_info($text) {
    $_SERVER['REQUEST_URI'] .= '#' . (is_string($text) ? $text : json_encode_array($text));
}

function ssl_encode($data) {
    if (!Config()->get('project.salt')) {
//        trigger_error('Необходимо задать настройку project.salt случайной строкой', E_USER_WARNING);
        Config()->set('project.salt', md5(date('Ymd')));
    }

    $key        = Config()->get('project.salt');
    $plainText  = json_encode_array($data);
    $ivlen      = openssl_cipher_iv_length($cipher = "AES-128-CBC");
    $iv         = openssl_random_pseudo_bytes($ivlen);
    $cipherText = openssl_encrypt($plainText, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    $hmac       = hash_hmac('sha256', $cipherText, $key, true);

    return base64_encode( $iv . $hmac . $cipherText );
}

function ssl_decode($base64) {
    if (!Config()->get('project.salt')) {
//        trigger_error('Необходимо задать настройку project.salt случайной строкой', E_USER_WARNING);
        Config()->set('project.salt', md5(date('Ymd')));
    }

    $key        = Config()->get('project.salt');
    $c          = base64_decode($base64);
    $ivlen      = openssl_cipher_iv_length($cipher = "AES-128-CBC");
    $iv         = substr($c, 0, $ivlen);
    $hmac       = substr($c, $ivlen, $sha2len=32);
    $cipherText = substr($c, $ivlen + $sha2len);
    $plainText  = openssl_decrypt($cipherText, $cipher, $key, OPENSSL_RAW_DATA, $iv);
    $calcmac    = hash_hmac('sha256', $cipherText, $key, true);

    if (hash_equals($hmac, $calcmac)) {
        return json_decode_array($plainText);
    }

    return null;
}

/**
 * Форматирование даты в локальной локали
 *
 * @link https://www.php.net/manual/en/intldateformatter.create.php
 * @link https://unicode-org.github.io/icu/userguide/format_parse/datetime/
 *
 * @param $format
 * @param $time
 * @param $timezone
 * @return string
 */
function intl_date($format, $time = null, $timezone = null, $locale = null)
{
    $fmt = datefmt_create(
        $locale ?? 'ru_RU',
        IntlDateFormatter::FULL,
        IntlDateFormatter::FULL,
        $timezone ?? date_default_timezone_get(),
        IntlDateFormatter::GREGORIAN,
        $format
    );

    if (is_int($time)) {
        $time = date('c', $time);
    }

    return $fmt->format($time instanceof DateTime ? $time : new DateTime(strtr($time ?? 'now', ['0000' => date('Y')])));
}

function activate_urls($text, $maxLen = 40) {
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

function upload_error_description($code) {
    $errors = [
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    ];

    return $errors[$code] ?? $code;
}
