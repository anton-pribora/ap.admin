<?php

PathAlias()->set('@layout', Config()->get('template.layout.error'));

if (Request()->isAcceptJson()) {
  ReturnJsonError('Page ' . Request()->action() . ' not found', 'not_found');
}

http_response_code(404);

Layout()->setVar('title', '404 Not found');

?>
<div class="container pt-3">
  <h1>Page Not Found <small style="color: red; font-family: Tahoma;">Error 404</small></h1>
  <p>The page you requested could not be found, either contact your webmaster or try again. Use your browsers <b>Back</b> button to navigate to the page you have prevously come from</p>
</div>
