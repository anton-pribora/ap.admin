<?php 

$file = $_GET['file'] ?? null;
$file = preg_replace('~\\.?\\./~', '/', basename($file));

if (empty($file)) {
    http_response_code(500);
    die('You must specify the file name');
}

$cdnUrl = '/cdn';
$cdnDir = __DIR__;

$aliases = [
    '@cacheUrl' => "$cdnUrl/cache",
    '@cacheDir' => "$cdnDir/cache",
    '@dist'     => "$cdnDir/dist",
];

$expand = function ($str) use ($aliases) {
    return strtr($str, $aliases);
};

$cache      = "$cdnDir/cache";
$dest       = "$cache/$file";

$components = json_decode(file_get_contents("$cdnDir/components.json"), JSON_OBJECT_AS_ARRAY);

$getComponent = function ($id) use ($components) {
    foreach ($components as $item) {
        if (in_array($id, (array) $item['id'])) {
            return $item;
        }
    }
    
    return null;
};

$fault = function ($error) use ($dest) {
    if (file_exists($dest)) {
        unlink($dest);
    }
    
    http_response_code(500);
    header('Content-type: text/plain');
    die($error);
};

$exec = function ($command) use ($fault) {
    exec($command, $output, $code);
    
    if ($code) {
        $fault("# $command : Return $code : Output : \n". join("\n", $output));
    }
};

$commands = [
    'cat' => function ($file, ...$filters) use ($dest, $expand, $exec) {
        $injects = ($filters ? ' | '. $expand(join(' | ', $filters)) : '');
        $file    = escapeshellarg($file);
        $dest    = escapeshellarg($dest);
        
        $exec("cat $file $injects >> $dest");
    },
    'copy' => function ($source, $dest) use ($expand, $exec) {
        $file = escapeshellarg($source);
        $dest = escapeshellarg($expand($dest));
        
        $exec("cp -r $file $dest 2>&1");
    }
];

if (!file_exists($cache)) {
    mkdir($cache, 0755);
}

chdir($cache);

$type = pathinfo($file, PATHINFO_EXTENSION);
$list = explode(',', pathinfo($file, PATHINFO_FILENAME));

if (file_exists($dest)) {
    unlink($dest);
}

foreach ($list as $id) {
    $item = $getComponent($id);
    $base = $cdnDir;
    
    if (empty($item)) {
        $fault("Unknown component $id");
    }
    
    if (isset($item['base'])) {
        $base = $expand($item['base']);
    }
    
    if (!isset($item[$type])) {
        continue;
    }
    
    chdir($base);
    
    foreach ($item[$type] as $command => $calls) {
        if (!isset($commands[$command])) {
            $fault("Unknown command $command");
        }
        
        foreach ($calls as $args) {
            $commands[$command](...(array) $args);
        }
    }
}

header('Location: /cdn/cache/'. $file);