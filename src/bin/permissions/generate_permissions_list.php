<?php

include __DIR__ . '/../../bootstrap.php';

$getComments = function ($path) {
    $tokens = token_get_all(file_get_contents($path));
    $comments = [];

    foreach ($tokens as [$id, $value]) {
        if ($id !== T_COMMENT) {
            continue;
        }

        $comments[] = trim(preg_replace(['~^//~', '~^/\*~', '~\*/$~', '~^#~'], '', trim($value)));
    }

    return join(PHP_EOL, $comments);
};

$parseComments = function ($path) use ($getComments) {
    $comments = $getComments($path);
    $result = [];

    if (preg_match_all('/@permission.(?P<key>\S+)(?:\s+(?P<value>.*))?/', $comments, $matches)) {
        foreach ($matches['key'] as $i => $key) {
            $result[$key] = $matches['value'][$i] ?? null;
        }

    }

    return $result;
};

$findPermissions = function ($folder) use ($parseComments) {
    $directory = new RecursiveDirectoryIterator($folder);
    $iterator = new RecursiveIteratorIterator($directory);

    $result = [];

    foreach ($iterator as $file) {
        /* @var $file SplFileInfo */
        if ($file->isDir()) {
            continue;
        } elseif (preg_match('/(^\.|\.[^.]+\.)/', $file->getFilename())) {
            continue;
        }

        $permission = __path_to_permission($file->getPathname());

        if ($file->isFile()) {
            $comments = $parseComments($file->getPathname());

            if ($comments) {
                $result[$permission] = $comments + ['name' => $file->getBasename('.' . $file->getExtension())];
            }
        }
    }

    return $result;
};

$toFlatArray = function ($array) {
    $items = [];

    foreach ($array as $key => $value) {
        $items[] = var_export($key, true) . ' => ' . var_export($value, true);
    }

    return '[' . join(', ', $items) . ']';
};

$result = [];

foreach (glob(ExpandPath('@permissions/*'), GLOB_ONLYDIR) as $identityTypeFolder)
{
    $identityType = basename($identityTypeFolder);
    $permissions  = $findPermissions($identityTypeFolder);

    if (file_exists($identityTypeFolder . '.php')) {
        $comments = $parseComments($identityTypeFolder . '.php');

        if ($comments) {
            $result[$identityType] = $comments + ['name' => $identityType];
        }
    }

    ksort($permissions);

    $result += $permissions;
}

$maxKey = 0;

foreach ($result as $key => $value) {
    $maxKey = max($maxKey, strlen($key) + 2);
}

ob_start();

echo "<?php\n";
echo "\n";
echo "// ВНИМАНИЕ! НЕ редактируйте этот файл, поскольку он генерируется через запуск " . __FILE__ . "\n";
echo "\n";
echo "return [\n";

foreach ($result as $key => $value) {
    printf("    %-{$maxKey}s => %s,\n", var_export($key, true), $toFlatArray($value));
}

echo "];\n";

$list = ob_get_clean();

$listFile = ExpandPath('@permissions/list.php');

file_put_contents($listFile, $list);

echo "Сгенерирован новый файл $listFile\n";
