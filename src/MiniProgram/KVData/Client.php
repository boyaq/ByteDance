<?php

/*
 * This file is part of the OtkurBiz/ByteDance.
 *
 * (c) alim <alim@bulutbazar.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace OtkurBiz\ByteDance\MiniProgram\KVData;

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
     * 当 key 是开发者所配置的排行榜 key 时，value 的内容应该满足KVData所指出的形式， 即形如 "{\"ttgame\":{\"score\":1}}"
     *
     * openid    登录用户唯一标识
     * signature    用户登录态签名，参考用户登录态签名算法
     * sig_method    用户登录态签名的编码方法，参考用户登录态签名算法
     * kv_list    (body 中) 要设置的用户数据
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     * @throws \OtkurBiz\ByteDance\Kernel\Exceptions\InvalidConfigException
     */
    public function set(string $openid, string $signature, string $sig_method, string $kv_list)
    {
        return $this->httpPost('api/apps/set_user_storage', ['openid'=>$openid, 'signature' => $signature, 'sig_method'=>$sig_method, 'kv_list'=>$kv_list]);
    }

    /**
     * Set User Storage
     * 当 key 是开发者所配置的排行榜 key 时，value 的内容应该满足KVData所指出的形式， 即形如 "{\"ttgame\":{\"score\":1}}"
     *
     * openid    登录用户唯一标识
     * signature    用户登录态签名，参考用户登录态签名算法
     * sig_method    用户登录态签名的编码方法，参考用户登录态签名算法
     * key	(body 中) 要删除的用户数据的 key list
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     * @throws \OtkurBiz\ByteDance\Kernel\Exceptions\InvalidConfigException
     */
    public function remove(string $openid, string $signature, string $sig_method, string $key)
    {
        return $this->httpPost('api/apps/remove_user_storage', ['openid'=>$openid, 'signature' => $signature, 'sig_method'=>$sig_method, 'key'=>$key]);
    }

}