<?php

UrlAlias()->set('@root' , '/');
UrlAlias()->set('@root/', '/');
UrlAlias()->set('@webroot', '/');
UrlAlias()->set('@webroot/', '/');

PathAlias()->set('@root'   , ROOT_DIR);
PathAlias()->set('@webroot', Config()->get('server.webroot'));

UrlAlias()->set('@cdn'         , '@root/cdn');
PathAlias()->set('@cdn'        , '@webroot/cdn');
UrlAlias()->set('@asseturl'    , '@root/asset');
PathAlias()->set('@assetpath'  , '@webroot/asset');
PathAlias()->set('@permissions', '@root/permissions');

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

PathAlias()->set('@files', '@root/uploads');

PathAlias()->set('@thumbnails', '@webroot/thumbnails');
UrlAlias()->set('@thumbnails' , '@webroot/thumbnails');

PathAlias()->set('@web_actions', Config()->get('server.webactions'));

PathAlias()->set('@consultant', '@web_actions/consultant');
UrlAlias()->set('@consultant', '@root/consultant');

PathAlias()->set('@widgets', '@root/widgets');
PathAlias()->set('@console', '@root/console');
