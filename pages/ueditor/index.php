<?php

use Miaoxing\File\Service\File;
use Miaoxing\Plugin\BaseController;

return new class extends BaseController {
    public function get()
    {
        $basePath = $this->plugin->getById('ueditor')->getBasePath();

        ob_start();
        require $basePath . '/public/libs/neditor/php/controller.php';
        $result = ob_get_clean();
        $result = json_decode($result, true);

        // 本地上传成功,接着上传到远程
        if ($result['state'] === 'SUCCESS' && $result['url']) {
            $ret = File::upload('public' . $result['url']);
            if ($ret->isSuc()) {
                $result['url'] = $ret['url'];
            } else {
                $result['state'] = $ret['message'];
            }
        }

        return $this->res->json($result);
    }

    public function post()
    {
        return $this->get();
    }
};
