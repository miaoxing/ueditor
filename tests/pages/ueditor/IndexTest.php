<?php

namespace MiaoxingTest\Pages\Ueditor;

use Miaoxing\Plugin\Service\Tester;
use Miaoxing\Plugin\Test\BaseTestCase;
use Wei\Res;

class IndexTest extends BaseTestCase
{
    public function testGet()
    {
        $res = Tester::query(['action' => 'config'])->get('ueditor');
        $this->assertInstanceOf(Res::class, $res);

        $json = json_decode($res->getContent(), true);
        $this->assertSame('uploadimage', $json['imageActionName']);
    }
}
