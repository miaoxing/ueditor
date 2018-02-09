<?php

namespace Miaoxing\Ueditor\Service;

/**
 * @property \Wei\Url $url
 * @method string url($uri)
 */
class Ueditor extends \Miaoxing\Plugin\BaseService
{
    /**
     * 附加到图片签名的地址,如CDN域名
     *
     * @var string
     */
    protected $imagePath;

    /**
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }
}
