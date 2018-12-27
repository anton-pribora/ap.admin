<?php

/**
 * @return \ApCode\Template\Layout\Layout
 */
function Layout($layout = NULL) {
    static $layouts;

    if (empty($layout)) {
        $layout = 'default';
    }

    if (empty($layouts[$layout])) {
        $layouts[$layout] = new \ApCode\Template\Layout\Layout($layout, PathAlias());
    }

    return $layouts[$layout];
}


/**
 * @return \ApCode\Alias\AliasInterface
 */
function UrlAlias() {
    static $alias;

    if (empty($alias)) {
        $alias = new ApCode\Alias\Alias();
    }

    return $alias;
}

/**
 * @return \ApCode\Alias\AliasInterface
 */
function PathAlias() {
    static $alias;

    if (empty($alias)) {
        $alias = new ApCode\Alias\Alias();
    }

    return $alias;
}

function Asset($path) {
    static $asset;

    if (empty($asset)) {
        $asset = new ApCode\Template\Asset\Asset(PathAlias(), UrlAlias());
    }

    return $asset->urlTo($path);
}

/**
 * @return \Gotcha\DbIndex
 */
function Gotcha() {
    static $index;

    if (empty($index)) {
        $index = new Gotcha\DbIndex(Db());
    }

    return $index;
}

/**
 * @return \Replica\ReplicaExporter
 */
function Replica() {
    static $replica;
    
    if (empty($replica)) {
        $replica = new Replica\ReplicaExporter(Db());
    }
    
    return $replica;
}

/**
 * @param string $name
 * @return \ApCode\Executor\ExecutorInterface
 */
function Module($name) : \ApCode\Executor\ExecutorInterface {
    static $modules = [];

    if (!isset($modules[$name])) {
        $modules[$name] = require ExpandPath("@modules/$name/module.php");
    }

    return $modules[$name];
}

function Run($command, ...$argsAndLastParams) {
    list($module, $action) = explode('/', 2) + [null, null];
    return Module($module)->execute($action, ...$argsAndLastParams);
}

function RunOnce($command, ...$argsAndLastParams) {
    list($module, $action) = explode('/', $command, 2) + [null, null];
    return Module($module)->executeOnce($action, ...$argsAndLastParams);
}


function RequireLib($lib) {
    RunOnce("misc/lib/$lib/enable.php");
}

/**
 * @return \ApCode\Template\Template
 */
function Template() {
    static $template;

    if (empty($template)) {
        $template = new ApCode\Template\Template();
        $template->setAlias(PathAlias());
    }

    return $template;
}

/**
 * @return \ApCode\Web\Request\Http
 */
function Request() {
    static $request;

    if (empty($request)) {
        $request = new \ApCode\Web\Request\Http();
    }

    return $request;
}

/**
 * @return \ApCode\Log\LoggerInterface
 */
function Logger() {
    static $logger;

    if (empty($logger)) {
        $logger = new ApCode\Log\Logger(dirname(ROOT_DIR) .'/logs');

        if (IS_CONSOLE) {
            $logger->format()->setFormat(
                "{datetime} {ip} {userId} [{userName}] «{message}»  time: {workTime}  queries: {queries}  q-time: {queriesTime}  mem: {memory}  inc: {files}  req: {requestId}  ses: {sessionId}  {method} {uri}\n"
            );
            $logger->format()->setStaticVariables([
                'datetime'    => function() {return date('[d-M-Y H:i:s T]');},
                'ip'          => '-',
                'requestId'   => Request()->id(),
                'sessionId'   => Session()->id() ?: '-',
                'userId'      => Identity()->getId() ?: '-',
                'userName'    => Identity()->getName() ?: '-',
                'workTime'    => function() {return sprintf('%.3f', Timer('system')->elapsed());},
                'queries'     => function() {return Db()->totalQueries();},
                'queriesTime' => function() {return sprintf('%.3f', Db()->totalTime());},
                'memory'      => function() {return sprintf('%.1fМб', memory_get_peak_usage(true) / 1024 / 1024);},
                'files'       => function() {return count(get_included_files());},
                'method'      => 'console',
                'uri'         => $GLOBALS['argv'][0],
                'message'     => '-',
            ]);
        } else {
            $logger->format()->setFormat(
                "{datetime} {ip} {userId} [{userName}] «{message}»  time: {workTime}  queries: {queries}  q-time: {queriesTime}  mem: {memory}  inc: {files}  req: {requestId}  ses: {sessionId}  {method} {uri}\n"
            );
            $logger->format()->setStaticVariables([
                'datetime'    => function() {return date('[d-M-Y H:i:s T]');},
                'ip'          => Request()->ip(),
                'requestId'   => Request()->id(),
                'sessionId'   => Session()->id() ?: '-',
                'userId'      => Identity()->getId() ?: '-',
                'userName'    => Identity()->getName() ?: '-',
                'workTime'    => function() {return sprintf('%.3f', Timer('system')->elapsed());},
                'queries'     => function() {return Db()->totalQueries();},
                'queriesTime' => function() {return sprintf('%.3f', Db()->totalTime());},
                'memory'      => function() {return sprintf('%.1fМб', memory_get_peak_usage(true) / 1024 / 1024);},
                'files'       => function() {return count(get_included_files());},
                'method'      => Request()->method(),
                'uri'         => Request()->uri(),
                'message'     => '-',
            ]);
        }
    }

    return $logger;
}

/**
 * @return \ApCode\Web\UrlManager
 */
function Url() {
    static $urlManager;

    if (empty($urlManager)) {
        $urlManager = new \ApCode\Web\UrlManager\Routed(Request()->fullUri(), UrlAlias());
    }

    return $urlManager;
}

/**
 * @param string $path
 * @param array $params
 * @return \Data\Url
 */
function ShortUrl($path, $params = [], $replaceParams = FALSE)
{
    return Url()->shortUrl($path, $params, $replaceParams);
}

/**
 * @param string $path
 * @param array $params
 * @return \Data\Url
 */
function FullUrl($path, $params = [], $replaceParams = FALSE)
{
    return Url()->fullUrl($path, $params, $replaceParams);
}

/**
 * @param string $path
 * @param array $params
 * @return \ApCode\Web\Url
 */
function ExternalUrl($path, $params = [])
{
    static $urlManager;
    
    if (empty($urlManager)) {
        $urlManager = new \ApCode\Web\UrlManager(Request()->fullUri(), UrlAlias());
    }
    
    return $urlManager->fullUrl($path, $params);
}

/**
 * @return \Auth\Identity
 */
function Identity() {
    if (Auth()->activeSession()) {
        if (Auth()->activeSession()->identity()) {
            return Auth()->activeSession()->identity();
        }
    }
    
    return new Auth\Identity();
}

/**
 * @return \Auth\Manager
 */
function Auth() {
    static $auth;

    if (empty($auth)) {
        $auth = new \Auth\Manager(Session()->container('auth'));
    }

    return $auth;
}

/**
 * @return \ApCode\Config\Config
 */
function Config() {
    static $config;

    if (empty($config)) {
        $config = new ApCode\Config\Config();
    }

    return $config;
}

/**
 * @return ApCode\Database\Pdo\MySql
 */
function Db() {
    static $db;

    if (empty($db)) {
        $db = new ApCode\Database\Pdo\MySql(
            Config()->get('db.dsn'),
            Config()->get('db.login'),
            Config()->get('db.password'),
            Config()->get('db.options', [])
        );
    }

    return $db;
}

/**
 * @param string $name
 * @return \ApCode\Misc\Timer
 */
function Timer($name = 'default') {
    static $timers = [];

    if (empty($timers[$name])) {
        $timers[$name] = new ApCode\Misc\Timer();
    }

    return $timers[$name];
}

/**
 * @return \ApCode\Session\Session
 */
function Session()
{
    static $session;

    if (empty($session)) {
        $session = new ApCode\Session\Session();
    }

    return $session;
}

/**
 * @return Halter
 */
function Halt() {
    static $halter = null;

    if (empty($halter)) {
        $halter = new Halter();
    }

    return $halter;
}

/**
 * @return ApCode\Web\Pagination
 */
function Pagination() {
    static $pagination;

    if (empty($pagination)) {
        $pagination = new ApCode\Web\Pagination();
        $pagination->setUrl(Url()->shortUrl('', $_GET), true);
    }

    return $pagination;
}

/**
 * @param string $path
 * @return \ApCode\Misc\FileMeta\FileMeta
 */
function Meta($path) {
    return ApCode\Misc\FileMeta\MetaManager::fileMeta($path);
}

/**
 * @return \Misc\Icons\Storage
 */
function Icons() {
    static $storage;

    if (empty($storage)) {
        $storage = new Misc\Icons\Storage();
    }

    return $storage;
}

function Icon($icon, $size = 'small') {
    return Icons()->get($icon, $size);
}

/**
 * @return \ApCode\Mail\Mailer
 */
function Mailer() {
    static $mailer;
    
    if (empty($mailer)) {
        $config = Config()->get('mail', []);
        
        if (!isset($config['onError'])) {
            $config['onError'] = function($text) {
                Logger()->error($text);
            };
        }
        
        if (!isset($config['afterSend'])) {
            $config['afterSend'] = function($text) {
                Logger()->log('mails', $text);
            };
        }
        
        $mailer = new ApCode\Mail\Mailer();
        $mailer->init($config);
    }
    
    return $mailer;
}
