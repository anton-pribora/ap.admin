<?php

/* @var $this \ApCode\Executor\RuntimeInterface */

$md = $this->argument();

// Обработка специальных конструкций:
//   ![Описание или название](ссылка "тип_содержимого")
//   [Описание или название](ссылка "тип_содержимого")

$youtube = function ($url, $title) {
    if (preg_match('~(/youtu.be/|youtube.com/watch\?v=)(\w+)~', $url, $matches)) {
        $id = $matches['2'];

        return <<<HTML
        <div class="ratio ratio-16x9">
          <iframe src="https://www.youtube.com/embed/{$id}?rel=0" title="{$title}" allowfullscreen></iframe>
        </div>
        HTML;
    }

    return null;
};

$replaceImage = function ($matches) {
    $text  = $matches['text'];
    $type  = $matches['type'];
    $url   = $matches['url' ];
    $param = $matches['param'] ?? null;

    return $param ?
        <<<HTML
        <div class="d-flex">
        <figure class="figure mx-auto">
          <a data-preview href="{$param}" target="_blank" rel="noopener noreferrer">
            <img src="{$url}" class="figure-img img-fluid rounded border border-1" alt="{$text}" title="{$text}">
          </a>
          <figcaption class="figure-caption text-center">{$text}</figcaption>
        </figure>
        </div>
        HTML
        :
        <<<HTML
        <div class="d-flex">
        <figure class="figure mx-auto">
          <img src="{$url}" class="figure-img img-fluid rounded border border-1" alt="{$text}" title="{$text}">
          <figcaption class="figure-caption text-center">{$text}</figcaption>
        </figure>
        </div>
        HTML
    ;
};


$replace = function ($matches) use ($youtube, $replaceImage) {
//    return '<pre>' . Html(print_r($matches, true)) . '</pre>';
    $text  = $matches['text'];
    $type  = $matches['type'];
    $url   = $matches['url' ];
    $param = $matches['param'] ?? null;

    return match ($type) {
        'image' => $replaceImage($matches),

        'video' => <<<HTML
            <div class="" title="{$text}">
              <video controls="" class="ratio ratio-16x9" preload="metadata">
                <source src="{$url}">
                Your browser does not support HTML5 video.
              </video>
            </div>
            HTML,

        'audio' => <<<HTML
            <div>
            <audio controls>
              <source src="{$url}">
              Your browser does not support the audio element.
            </audio>
            </div>
            HTML,

        'excel' => <<<HTML
            <a data-{$type} href="{$url}" target="_blank" rel="noopener noreferrer" title="Открыть {$text}"><i class="bi bi-file-earmark-excel text-success me-1"></i>{$text}</a>
            HTML,
        'word' => <<<HTML
            <a data-{$type} href="{$url}" target="_blank" rel="noopener noreferrer" title="Открыть {$text}"><i class="bi bi-file-earmark-word text-primary me-1"></i>{$text}</a>
            HTML,
        'powerpoint' => <<<HTML
            <a data-{$type} href="{$url}" target="_blank" rel="noopener noreferrer" title="Открыть {$text}"><i class="bi bi-file-earmark-easel text-danger me-1"></i>{$text}</a>
            HTML,
        'archive' => <<<HTML
            <a data-{$type} href="{$url}" target="_blank" rel="noopener noreferrer" title="Открыть {$text}"><i class="bi bi-file-zip text-primary me-1"></i>{$text}</a>
            HTML,

        'pdf' => <<<HTML
            <a data-{$type} href="{$url}" target="_blank" rel="noopener noreferrer" title="Открыть {$text}"><i class="bi bi-file-earmark-pdf text-danger me-1"></i>{$text}</a>
            HTML,

        'youtube' => $youtube($url, $text) ?: $matches[0],

        default => $matches[0]
    };
};


$md = preg_replace_callback('~!\[(?P<text>[^]]+)]\((?P<url>[^ )]+)\s+"(?P<type>[^:"]+)(:(?P<param>[^"]+))?"\)~', $replaceImage, $md);

$parser = new \Erusev\Parsedown();

$html = $parser->parse($md);

$codes = new ArrayObject([]);

// Блоки кода
$html = preg_replace_callback('~<pre><code>([^<]+)</code></pre>~', function ($matches) use ($codes) {
    $id = uniqid();

    $codes[$id] = '<pre class="p-3 bg-light rounded-2 shadow-sm"><code>' . $matches[1] . '</code></pre>';

    return $id;
}, $html);

// Коварные ссылки
$html = preg_replace_callback('~<a href="(?P<url>[^"]+)"( title="(?P<type>[^:"]+)(:(?P<param>[^"]+))?")?>(?P<text>[^<]+)</a>~', $replace, $html);

// Маскируем ссылки на внешние источники
$root = (string) ExternalUrl('/');
$html = preg_replace('~(<a href="(?!' . $root . '|/)[^"]+"(?: title="[^"]+")?)>([^<]+)~i', '$1 rel="nofollow noopener noreferrer" target="_blank">$2<i class="bi bi-box-arrow-up-right ms-1"></i>', $html);

// Таблицы
$html = preg_replace('~<table>~', '<table class="table table-bordered w-auto">', $html);

// Возвращаем блоки кода
$html = strtr($html, iterator_to_array($codes));

return $html;
