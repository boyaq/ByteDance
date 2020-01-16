<?php

use OtkurBiz\ByteDance\Factory;
use PHPUnit\Framework\TestCase;

class EncryptorTest extends TestCase
{
    use \OtkurBiz\ByteDance\Kernel\Traits\InteractsWithCache;

    public function testDecrypt()
    {
        $config = require __DIR__.'/../../config.php';
        $app = Factory::make($config);
        $encryptedData = 'OtxCmzxeE3pvDlNEjw8bzVyDY3b5+RhoGDkKHjnXo8Eqesu0W/qCCGa46nH/XaluxKI7Xs78trpk+ZcG8monLidSN+fgvIqgSLwTom9N7e3RZXieCheqToR33qiC+PRnQ3sda/bYbeljPxqoehWm/5iEr8113Ee5uzmUzHGFj4uuUmdn4YOg405RD1t5qeZ0DEccV6Rri0cHsnQqsrVnn+z6yIup5WVK0JgmCzANwODpR0doakAtcoOC5Dm/9ZHU8eaagdjM+hb4tb7NyRvqNCORGvE1DU0a6faQXNG3klieNFjFlGj/SmILstqv8qdCOeDK5xWBgVl2yDzbcLeQhSAUw4yLY9xyKWZp+XlFy8KxDfCQpJFk6cNRkcFrwWzR';
        $iv = 'YxAX3Kc6f0q8QVTb3YG/Ug==';
        $code = '067c06d0f1e8cbdb';
        //$session = $app->auth->session($code);

        $session = 'x4yTGYrsW4sungMedrPi+g==';
        $value = $app->encryptor->decryptData($session, $iv, $encryptedData);

        var_dump($value);die;
    }
}
