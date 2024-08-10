<?php

use Miaoxing\App\Middleware\CheckPagePermission;
use Miaoxing\File\Service\File;
use Miaoxing\Plugin\BasePage;

return new class extends BasePage {
    public function init()
    {
        parent::init();
        $this->removeMiddleware(CheckPagePermission::class);
    }

    public function get()
    {
        $basePath = $this->plugin->getById('ueditor')->getBasePath();

        ob_start();
        require $basePath . '/public/libs/neditor/php/controller.php';
        $result = ob_get_clean();

        if ($this->req->getQuery('callback')) {
            // Remove "callback()" wrapper
            $result = substr($result, strlen($this->req->getQuery('callback')) + 1, -1);
        }

        $result = json_decode($result, true);

        // 本地上传成功,接着上传到远程
        if ('SUCCESS' === $result['state'] && $result['url']) {
            $ret = File::saveLocal('public' . $result['url'], [
                'origName' => $result['original'],
                'size' => $result['size'],
            ]);
            if ($ret->isSuc()) {
                $result['url'] = $ret['data']['url'];
            } else {
                $result['state'] = $ret['message'];
            }
        }

        return $this->res->jsonp($result);
    }

    public function post()
    {
        return $this->get();
    }
};
