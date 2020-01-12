<?php
/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace OtkurBiz\ByteDance\MiniProgram\Auth;

use OtkurBiz\ByteDance\Kernel\AccessToken as BaseAccessToken;

/**
 * Class AuthorizerAccessToken.
 *
 * @author overtrue <i@overtrue.me>
 */
class AccessToken extends BaseAccessToken
{
    /**
     * @var string
     */
    protected $endpointToGetToken = 'https://developer.toutiao.com/api/apps/token';

    /**
     * @return array
     */
    protected function getCredentials(): array
    {
        $client_secret = $this->app['config']['app_secret'];
        date_default_timezone_set('Asia/Shanghai');
        $client_id = $this->app['config']['app_id'];
        $grand_type = 'client_credential';

        return [
            'grant_type' => $grand_type,
            'appid'      => $client_id,
            'secret'     => $client_secret,
        ];
    }
}
