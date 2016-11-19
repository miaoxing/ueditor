<?php

namespace Miaoxing\Ueditor\Service;

/**
 * @property \Wei\Url $url
 * @method string url($uri)
 */
class Ueditor extends \miaoxing\plugin\BaseService
{
    /**
     * 上传图片的地址
     *
     * @var string
     * @todo rename 或者移到asset统一管理?
     */
    protected $imageUrl;

    /**
     * 附加到图片签名的地址,如CDN域名
     *
     * @var string
     */
    protected $imagePath;

    /**
     * @var array
     */
    protected $localDomain = [];

    /**
     * 获取Ueditor的配置
     *
     * @return string
     */
    public function getConfigJson()
    {
        $app = $this->app->getNamespace();
        return json_encode([
            'imageUrl' => $this->imageUrl . $this->url->append('/ueditor/image-upload', ['app' => $app]),
            'catcherUrl' => $this->imageUrl . $this->url->append('/ueditor/get-remote-image', ['app' => $app]),
            'localDomain' => $this->localDomain,
        ]);
    }

    /**
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }
}
