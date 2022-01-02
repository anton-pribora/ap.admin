<?php

UrlAlias()->set('@root' , '/');
UrlAlias()->set('@root/', '/');

PathAlias()->set('@root'   , ROOT_DIR);
PathAlias()->set('@webroot', Config()->get('server.webroot'));

UrlAlias()->set('@cdn'  , '@root/cdn');
UrlAlias()->set('@asseturl'  , '@root/asset');
PathAlias()->set('@assetpath', '@webroot/asset');

PathAlias()->set('@modules'  , '@root/modules');
PathAlias()->set('@templates', '@root/templates');
PathAlias()->set('@template' , Config()->get('template.name'));
PathAlias()->set('@template/', '@templates/{@template}/');

PathAlias()->set('@layouts'    , '@template/layouts');
PathAlias()->set('@layout'     , Config()->get('template.layout.main'));
PathAlias()->set('@layout/'    , '@layouts/{@layout}/');
PathAlias()->set('@layout.pdf' , '@layouts/' . Config()->get('template.layout.pdf'));
PathAlias()->set('@layout.mail', '@layouts/' . Config()->get('template.layout.mail'));

PathAlias()->set('@views'   , '@template/views');

PathAlias()->set('@mail'     , '@views/mail');
PathAlias()->set('@extra'    , '@views/extra');

PathAlias()->set('@pagination', '@extra/pagination.php');
PathAlias()->set('@code'      , '@extra/code.php');
PathAlias()->set('@totalFound', '@extra/totalFound.php');

PathAlias()->set('@uploads', '@root/uploads');
UrlAlias()->set('@uploads', '@root/uploads');

PathAlias()->set('@thumbnails', '@webroot/thumbnails');
UrlAlias()->set('@thumbnails' , '@root/thumbnails');

UrlAlias()->set('@consultant', '@root/consultant');

PathAlias()->set('@widgets', '@root/widgets');
PathAlias()->set('@console', '@root/console');
