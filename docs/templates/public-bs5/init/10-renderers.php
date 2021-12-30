<?php

use ApCode\Template\Layout\Renderer;

$cdn = Config()->get('cdn.url');

Layout()->setRendererIfEmpty('head.title'    , new Renderer\Tag('title', ' / '));
Layout()->setRendererIfEmpty('head.metas'    , new Renderer\EmptyTag('meta', "\n"));
Layout()->setRendererIfEmpty('head.css.code' , new Renderer\Tag('style', "\n", ['type' => 'text/css']));
Layout()->setRendererIfEmpty('head.css.links', new Renderer\CssLinks());
Layout()->setRendererIfEmpty('head.js.links' , new Renderer\JsLinks());
Layout()->setRendererIfEmpty('head.js.code'  , new Renderer\Tag('script', "\n", ['type' => 'text/javascript']));

Layout()->setRendererIfEmpty('body.alerts'  , new Renderer\Alerts());
Layout()->setRendererIfEmpty('body.css.code', new Renderer\Tag('style', "\n", ['type' => 'text/css']));
Layout()->setRendererIfEmpty('body.js.begin', new Renderer\Tag('script', "\n", ['type' => 'text/javascript']));
Layout()->setRendererIfEmpty('body.js.links', new Renderer\JsLinks());
Layout()->setRendererIfEmpty('body.js.code' , new Renderer\Tag('script', "\n", ['type' => 'text/javascript']));

Layout()->setRenderer('stats', new Renderer\Callback(function (){}, function (){
    return sprintf("<div>Время работы: %.3f сек. Файлов: %d. Запросов: %d. Время выполнения запросов: %.3f сек.</div>",
        Timer('system')->elapsed(),
        count(get_included_files()),
        Db()->totalQueries(),
        Db()->totalTime()
    );
}));
