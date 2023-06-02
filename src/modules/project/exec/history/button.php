<?php

/* @var $this \ApCode\Executor\PhpFileExecutor */

use ApCode\Html\Element\A;
use ApCode\Html\Element\UnescapedText;

$section  = $this->param('section');
$recordId = $this->param('recordId');
$viewAll  = $this->param('viewAll', false);
$meta     = (array) $this->param('meta');

$section = ssl_encode(['_' => $section, 'v' => $viewAll]);

$link = new A(new UnescapedText('<i class="bi bi-clock-history me-1"></i>История изменений'), 'javascript: void(0)');
$link->setAttribute('onclick', 'viewHistory(' . json_encode($section) . ', ' . json_encode($recordId) . ', ' . json_encode($meta) . ')');

$baseUrl = json_encode((string) ExternalUrl('@consultant/history/'), JSON_UNESCAPED_SLASHES);

Layout()->appendOnce('body.js.code', <<<JS
function viewHistory(section, id, meta)
{
	const options = [];

	options.push('width=900' );
	options.push('height=600');
	options.push('left=50'   );
	options.push('top=50'    );
	options.push('scrollbars=yes');
    
    const url = new URL({$baseUrl});

    url.searchParams.set('section', section);
    
    if (id) {
      url.searchParams.set('recordId', id);
    }
    
    if (meta) {
      for (const [key, value] of Object.entries(meta)) {
        url.searchParams.set(`meta[\${key}]`, value)
      }
    }

	const w = window.open(url, 'history', options.join(','));

	w.focus();
}
JS
);

return $link;
