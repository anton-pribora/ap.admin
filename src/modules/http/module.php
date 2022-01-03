<?php

use ApCode\Executor\PhpFileExecutor;

$folder = ExpandPath(Config()->get('server.webactions'));

return new class ($folder) extends PhpFileExecutor {
    protected function actionExists()
    {
        return true;
    }

    protected function doAction()
    {
        $this->initAction();

        if (Halt()->action()) {
            return ;
        }

        if (parent::actionExists()) {
            return parent::doAction();
        }

        return Module('errors')->execute('http/404.php', [
            'action' => $this->action,
            'dir'    => $this->baseDir,
            'file'   => $this->getActionFile()
        ]);
    }

    protected function doActionOnce()
    {
        throw new \Exception('HTTP module doesn\'t support execute method once');
    }

    private function initAction()
    {
        if (Halt()->init()) {
            return ;
        }

        $this->action = ltrim($this->action, '/');

        $dir       = dirname($this->action);
        $path      = $this->baseDir;
        $pathArray = array_merge([''], array_filter(explode('/', $dir), function ($dir) {
            return $dir !== '' && $dir !== '.';
        }));

        foreach ($pathArray as $name) {
            $path .= $name;

            if (!file_exists($path)) {
                break;
            }

            $path .= '/';
            $mask = $path . '*.init.php';

            foreach (glob($mask) as $file) {
                include $file;

                if (Halt()->init()) {
                    return ;
                }
            }
        }

        // Отключаем повторную инициализацию (чтобы можно было вызывать инклюды внутри действий)
        Halt()->init(true);
    }
};
