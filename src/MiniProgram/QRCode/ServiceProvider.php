<?php
/*
 * This file is part of the otkurbiz/bytedance.
 *
 * (c) alim <alim@bulutbazar.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace OtkurBiz\ByteDance\MiniProgram\QRCode;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 *
 * @author alim <alim@bulutbazar.com>
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}.
     */
    public function register(Container $app)
    {
        !isset($app['qrcode']) && $app['qrcode'] = function ($app) {
            return new Client($app);
        };
    }
}