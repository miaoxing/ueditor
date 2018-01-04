<?php

namespace Miaoxing\Ueditor;

class Plugin extends \Miaoxing\Plugin\BasePlugin
{
    protected $name = 'Ueditor PHP后端';

    public function onBeforePageScript()
    {
        $controller = $this->app->getController();
        if (strpos($controller, 'admin') !== false) {
            $this->display();
        }
    }
}
