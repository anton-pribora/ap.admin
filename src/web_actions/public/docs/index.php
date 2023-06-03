<?php

Layout()->append('head.css.links', 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/styles/mono-blue.min.css');
Layout()->append('body.js.links', 'https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/highlight.min.js');
Layout()->append('body.js.code', 'hljs.initHighlightingOnLoad();');

$parsedownExists = class_exists('Parsedown');

ob_start();
?>
<div class="container">
  <div class="row mt-3">
    <div class="col-md-8 content order-2 order-md-1">
<?php
if (!$parsedownExists) {
    $src = ExpandPath('@root');
    Alert(<<<HTML
Please install Markdown parser by following commands: <br />
<code>cd $src</code><br>
<code>composer require erusev/parsedown</code>
HTML
      , 'warning');
}
?>
      {!CONTENT}
    </div>
    <div class="col-md-4  order-1 order-md-2">
      <div class="menu sticky-top p-3 bg-light">
        <h5 class="text-body-secondary">Содержание</h5>
        <div class="nav flex-column">
          {!TOC}
          <div class="px-3"><a href="#">[Наверх]</a></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php

$template = ob_get_clean();

$text = file_get_contents(ExpandPath('@root/../README.md'));

if ($parsedownExists) {
    $parser = new Parsedown();
    $html = $parser->text($text);
} else {
    $html = (string) new \ApCode\Html\Element\Pre(new \ApCode\Html\Element\Code($text));
}

$filters = [
    '/<table>/' => '<table class="table table-bordered table-sm w-auto">',
    '/<thead>/' => '<thead class="thead-light">',
    '/<a[^>]+href="[^"]+"/' => '$0 target="_blank" rel="noreferrer noopener"',
    '/<pre/'    => '<pre class="border border-light bg bg-light rounded p-2"',
    '/<h1/'     => '<h1 class="border-bottom pb-2 border-light"',
    '/\t/'      => '    ',
    '/{TOP}/'   => '<a href="#">[Наверх]</a>',
];

$html = preg_replace(array_keys($filters), array_values($filters), $html);

$html = preg_replace_callback('~<p><img src="([^"]+)" alt="([^"]+)".*></p>~uUi', function ($matches) {
  $asset = Asset(__dir($matches[1]));
  $caption = $matches[2];

  return "<div><figure class=\"figure\"><img src=\"$asset\" alt=\"$caption\" /><figcaption class=\"figure-caption text-center\">$caption</figcaption></figure></div>";
}, $html);

$root = new ArrayObject([
    'level'     => 1,
    'numbering' => '',
    'subItems'  => [],
    'parent'    => null,
]);

$parent = $root;

$html = preg_replace_callback('~<h([2-6])[^>]*>([^<]+)</h[2-6]>~', function($matches) use ($parent) {
    static $hashes = [];

    $hash = trim($matches[2]) ?: '_';

    if (isset($hashes[$hash])) {
        $hashes[$hash] += 1;
        $hash .= ' (' . $hashes[$hash] .')';
    } else {
        $hashes[$hash] = 1;
    }

    $level = $matches[1];
    $hash = htmlentities($hash);

    if ($level - $parent['level'] === 1) {
        // Ничего не делаем
    } elseif ($level - $parent['level'] > 1) {
        $parent = $parent['subItems'][ array_key_last($parent['subItems']) ];
    } else {
        do {
            $parent = &$parent['parent'];
        } while ($level >= $parent['level'] );
    }

    $item = new ArrayObject([
        'level'    => $level,
        'subItems' => [],
        'parent'   => $parent,
    ]);

    $parent['subItems'][] = $item;
    $i = $parent['numbering'] . count($parent['subItems']) .'.';

    $item['numbering'] = $i;

    $hash = $i . $hash;
    $hash = strtr($hash, [' ' => '-']);

    $item['link'] = '<a href="#' . $hash . '">' . $matches[2] . '</a>';

    return "<h{$matches[1]} id=\"$hash\">{$i} {$matches[2]} <a href=\"#$hash\" class=\"text-light\">¶</a></h{$matches[1]}>";
}, $html);

$buildToc = null;
$buildToc = function($items, $tag = 'ol') use (&$buildToc) {
    $result = ["<$tag>"];

    foreach ($items as $item) {
        $result[] = '<li>' . ($item['link'] ?? '');

        if (!empty($item['subItems'])) {
            $result[] = $buildToc($item['subItems'], 'ul');
        }

        $result[] = '</li>';
    }

    $result[] = "</$tag>";

    return join(PHP_EOL, $result);
};

$toc = $buildToc($root['subItems']);

echo strtr($template, [
    '{!CONTENT}' => $html,
    '{!TOC}'     => $toc,
]);
