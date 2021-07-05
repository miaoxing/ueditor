<?php

namespace Miaoxing\Ueditor;

use Miaoxing\Plugin\Auth\SessionAuth;
use Miaoxing\Plugin\BasePlugin;

/**
 * @mixin \AppMixin
 */
class UeditorPlugin extends BasePlugin
{
    protected $name = 'Ueditor 富文本编辑器';

    public function onAppInit()
    {
        // TODO ueditor 上传文件是 POST 表单，不支持 JWT，改为 Session 登录
        if ('/ueditor' === $this->req->getPathInfo()) {
            wei()->setConfig('user', [
                'authClass' => SessionAuth::class,
            ]);
        }
    }
}
