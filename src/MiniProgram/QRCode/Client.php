<?php

/*
 * This file is part of the OtkurBiz/ByteDance.
 *
 * (c) alim <alim@bulutbazar.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace OtkurBiz\ByteDance\MiniProgram\QRCode;

use OtkurBiz\ByteDance\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author alim <alim@bulutbazar.com>
 */
class Client extends BaseClient
{
    /**
     * Set User Storage
     * 获取小程序/小游戏的二维码。该二维码可通过任意 app 扫码打开，能跳转到开发者指定的对应字节系 app 内拉起小程序/小游戏， 并传入开发者指定的参数。通过该接口生成的二维码，永久有效，暂无数量限制
     *
     * appname	否	toutiao	是打开二维码的字节系 app 名称，默认为今日头条，取值如下表所示
        * toutiao	今日头条
        * douyin	抖音
        * pipixia	皮皮虾
        * huoshan	火山小视频
     * path	否		小程序/小游戏启动参数，小程序则格式为 encode({path}?{query})，小游戏则格式为 JSON 字符串，默认为空
     * width	否	430	二维码宽度，单位 px，最小 280px，最大 1280px，默认为 430px
     * line_color	否	{"r":0,"g":0,"b":0}	二维码线条颜色，默认为黑色
     * background	否		二维码背景颜色，默认为透明
     * set_icon	否	FALSE	是否展示小程序/小游戏 icon，默认不展示
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     * @throws \OtkurBiz\ByteDance\Kernel\Exceptions\InvalidConfigException
     */
    public function create(string $appname, string $path, string $width, string $line_color, string $background, string $set_icon)
    {
        return $this->httpPost('api/apps/qrcode', ['appname'=>$appname, 'path' => $path, 'width'=>$width, 'line_color'=>$line_color, 'background'=>$background, 'set_icon'=>$set_icon]);
    }


}