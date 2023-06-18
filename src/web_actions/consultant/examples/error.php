<?php

Layout()->append('breadcrumbs', 'Страница с ошибкой');

?>
<h3>Вот так выглядит ошибка на окружении <?=Config()->get('APPLICATION_ENV')?>:</h3>

<?php trigger_error('Пример ошибки', E_USER_WARNING);?>
