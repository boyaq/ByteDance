a<?php
use OtkurBiz\ByteDance\Factory;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testCode()
    {
        $config = require __DIR__.'/../../config.php';
        $app = Factory::make($config);
        $code = '123';
        $result = $app->auth->session($code);

        $this->assertArrayHasKey('session_key', $result);
        $this->assertArrayHasKey('openid', $result);
    }

    public function testAnonymousCode()
    {
        $config = require __DIR__.'/../../config.php';
        $app = Factory::make($config);
        $code = '123';
        $result = $app->auth->session($code, true);

        $this->assertArrayHasKey('session_key', $result);
        $this->assertArrayHasKey('anonymous_openid', $result);
    }
}
