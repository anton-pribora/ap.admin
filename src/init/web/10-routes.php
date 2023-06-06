<?php

use ApCode\Web\UrlManager\Routed;

if (Url() instanceof Routed) {
    Url()->addRoutes([
        [
            'pattern' => '~^@root/public/file/(?<guid>\w{10,})/(?<fileName>.+)?~',
            'url'     => '@root/public/file/{guid}/{fileName}',
            'action'  => '@root/public/file/index.php',
        ],
    ]);

    Url()->applyRoutes(Request());
}
