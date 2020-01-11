<?php
use PHPUnit\Framework\TestCase;
use OtkurBiz\ByteDance\Factory;
class AccessTokenTest extends TestCase
{
	public function testToken()
	{
		$config = require __DIR__ . '/../../config.php';
		$app = Factory::make($config);
		$token = $app->access_token->getToken();

		$this->assertArrayHasKey('access_token', $token);
	}
}