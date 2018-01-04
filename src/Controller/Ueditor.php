<?php

namespace Miaoxing\Ueditor\Controller;

use Miaoxing\Ueditor\Lib\Uploader;
use Wei\Request;

class Ueditor extends \Miaoxing\Plugin\BaseController
{
    protected $guestPages = [
        'ueditor', // 设置为不用登录,因为上传的IP地址和域名不共享登录态
    ];

    public function imageUploadAction($req)
    {
        // 上传配置
        $config = [
            'savePath' => [
                wei()->upload->getDir(),
            ],
            'maxSize' => 1000, // 单位KB
            'allowFiles' => ['.gif', '.png', '.jpg', '.jpeg', '.bmp'],
            'fileNameFormat' => $req['fileNameFormat'],
        ];

        // 上传图片框中的描述表单名称
        $title = htmlspecialchars($req['pictitle'], ENT_QUOTES);
        $path = htmlspecialchars($req['dir'], ENT_QUOTES);

        // 获取存储目录
        if ($req('fetch')) {
            $this->response->setHeader('Content-Type', 'text/javascript');

            return 'updateSavePath(' . json_encode($config['savePath']) . ');';
        }

        if (empty($path)) {
            $path = $config['savePath'][0];
        }

        // 上传目录验证
        if (!in_array($path, $config['savePath'])) {
            return $this->response->json([
                'state' => '非法上传目录',
            ]);
        }

        // 每个应用的图片,存储到自己的目录下
        $config['savePath'] = $path . '/' . $this->app->getId();

        // 生成上传实例对象并完成上传
        $up = new Uploader('upfile', $config);

        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     "originalName" => "",   //原始文件名
         *     "name" => "",           //新文件名
         *     "url" => "",            //返回的地址
         *     "size" => "",           //文件大小
         *     "type" => "" ,          //文件类型
         *     "state" => ""           //上传状态，上传成功时必须返回"SUCCESS"
         * )
         */
        $info = $up->getFileInfo();

        // TODO 待ueditor升级后,改为前台去上传到远程
        if ($info['state'] == 'SUCCESS') {
            $ret = wei()->file->upload($info['url']);
            if ($ret['code'] === 1) {
                $info['url'] = $ret['url'];
            }
        }

        /**
         * 向浏览器返回数据json数据
         * {
         *   'url'      :'a.jpg',   //保存后的文件路径
         *   'title'    :'hello',   //文件描述，对图片来说在前端会添加到title属性上
         *   'original' :'b.jpg',   //原始文件名
         *   'state'    :'SUCCESS'  //上传状态，成功时返回SUCCESS,其他任何值将原样返回至图片上传框中
         * }
         */
        return $this->response->json([
            'url' => $info['url'],
            'title' => $title,
            'original' => $info['originalName'],
            'state' => $info['state'],
        ]);
    }

    /**
     * 下载远程图片到服务器,并返回本地或CDN的地址
     *
     * @param Request $req
     * @return $this
     */
    public function getRemoteImageAction($req)
    {
        // 忽略抓取时间限制
        set_time_limit(0);

        $uri = str_replace('&amp;', '&', $req['upfile']);

        // ue_separate_ue 用于传递数据分割符号
        $imgUrls = explode('ue_separate_ue', $uri);

        $tmpNames = [];
        foreach ($imgUrls as $imgUrl) {
            $ret = wei()->file->upload($imgUrl);
            if ($ret['code'] === 1) {
                $tmpNames[] = $ret['url'];
            } else {
                $tmpNames[] = 'error';
            }
        }

        $this->response->setHeader('Access-Control-Allow-Origin', '*');

        return $this->response->json([
            'url' => implode('ue_separate_ue', $tmpNames),
            'urls' => $tmpNames,
            'tip' => '远程图片抓取完成',
            'srcUrl' => $uri,
        ]);
    }
}
