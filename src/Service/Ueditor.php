<?php

namespace Miaoxing\Ueditor\Service;

/**
 * @property \Wei\Url $url
 * @method string url($uri)
 */
class Ueditor extends \Miaoxing\Plugin\BaseService
{
    /**
     * 上传图片的地址
     *
     * @var string
     * @todo rename 或者移到asset统一管理?
     */
    protected $imageUrl;

    /**
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }
}
