<?php
/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace OtkurBiz\ByteDance\MiniProgram;

use OtkurBiz\ByteDance\Kernel\ServiceContainer;

/**
 * Class Application.
 *
 * @property \OtkurBiz\ByteDance\MiniProgram\Auth\AccessToken $access_token
 * @property \OtkurBiz\ByteDance\MiniProgram\Auth\Client $auth
 * @property \OtkurBiz\ByteDance\MiniProgram\KVData\Client $kv
 * * @property \OtkurBiz\ByteDance\MiniProgram\Encryptor $encryptor
 * @property \OtkurBiz\ByteDance\MiniProgram\QRCode\Client $qrcode
 * @property \OtkurBiz\ByteDance\MiniProgram\Message\Client $message
 */
class Application extends ServiceContainer
{
    /**
     * @var array
     */
    protected $providers = [
        Auth\ServiceProvider::class,
        KVData\ServiceProvider::class,
        QRCode\ServiceProvider::class,
        Message\ServiceProvider::class,
    ];
}
