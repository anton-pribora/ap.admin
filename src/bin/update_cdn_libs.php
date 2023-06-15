<?php

include __DIR__ . '/../bootstrap.php';

$files = glob(ExpandPath('@cdn/*/download.txt'));

foreach ($files as $file) {
    $folder = dirname($file);
    $lines  = file($file);

    chdir($folder);

    foreach ($lines as $line) {
        $line = trim(preg_replace('/#.*/', '', $line));

        if (empty($line)) {
            continue;
        }

        [$source, $output, $params] = preg_split('/\s+/', $line, 3) + [null, null, null];

        if (empty($output)) {
            $output = basename($source);
        }

        if (str_ends_with($output, '/')) {
            $output .= basename($source);
        }

        $outputFolder = dirname($output);

        if (!file_exists($outputFolder)) {
            mkdir($outputFolder, 0755, true);
        }

        echo "Download $source to $output\n";

        $fpFrom = fopen($source, 'r');
        $fpTo   = fopen($output, 'w');

        if ($fpFrom && $fpTo) {
            stream_copy_to_stream($fpFrom, $fpTo);
        } else {
            echo "    Ошибка: "  . json_encode_array(error_get_last()['message']) . PHP_EOL;
        }

        fclose($fpFrom);
        fclose($fpTo);
    }
}
