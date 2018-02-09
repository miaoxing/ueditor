<?php

namespace Miaoxing\Ueditor\Controller;

use Miaoxing\Ueditor\Lib\Uploader;
use Wei\Request;

class Ueditor extends \Miaoxing\Plugin\BaseController
{
    protected $guestPages = [
        'ueditor', // 暂不用登录
    ];

    public function indexAction(Request $req)
    {
        $basePath = $this->plugin->getById('ueditor')->getBasePath();

        ob_start();
        require $basePath . '/public/libs/neditor/php/controller.php';
        $result = ob_get_clean();
        $result = json_decode($result, true);

        // 本地上传成功,接着上传到远程
        if ($result['state'] === 'SUCCESS' && $result['url']) {
            $ret = wei()->file->upload($result['url']);
            if ($ret['code'] === 1) {
                $result['url'] = $ret['url'];
            }
        }

        return $this->response->json($result);
    }
}
