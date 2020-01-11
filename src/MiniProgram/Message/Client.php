<?php

/*
 * This file is part of the OtkurBiz/ByteDance.
 *
 * (c) alim <alim@bulutbazar.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace OtkurBiz\ByteDance\MiniProgram\Message;

use OtkurBiz\ByteDance\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author alim <alim@bulutbazar.com>
 */
class Client extends BaseClient
{
    /**
     * 发送模版消息
     * 目前只有今日头条支持，抖音和 lite 接入中
     *
     * touser	String	是	要发送给用户的 open id, open id 的获取请参考登录
     * template_id	String	是	在开发者平台配置消息模版后获得的模版 id
     * page	String	否	点击消息卡片之后打开的小程序页面地址，空则无跳转
     * form_id	String	是	可以通过<form />组件获得 form_id, 获取方法
     * data	dict<String, SubData>	是	模板中填充着的数据，key 必须是 keyword 为前缀
     *SubData
        *SubData 也是 dict，结构如下：
        *名称	类型	是否必填
        *value	String	是
     * eg: {"access_token": "YOUR_ACCESS_TOKEN", "app_id": "YOUR_APP_ID", "data": {"keyword1": {"value": "v1"}, "keyword2": {"value": "v2"}}, "page": "pages/index", "form_id": "YOUR_FORM_ID", "touser": "USER_OPEN_ID", "template_id": "YOUR_TPL_ID"}
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     * @throws \OtkurBiz\ByteDance\Kernel\Exceptions\InvalidConfigException
     */
    public function create(string $touser, string $template_id, string $page, string $form_id, mixed $data)
    {
        return $this->httpPost('api/apps/game/template/send', ['touser'=>$touser, 'template_id' => $template_id, 'page'=>$page, 'form_id'=>$form_id, 'data'=>$data]);
    }


}