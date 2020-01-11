<?php
/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace OtkurBiz\ByteDance;

/**
 * Class Factory.
 * @method static \OtkurBiz\ByteDance\Application    bytedance(array $config)
 */
class Factory
{
    /**
     * @param array $config
     *
     * @return \OtkurBiz\ByteDance\Application
     */
    public static function make(array $config, $name = 'miniProgram')
    {
        $namespace = Kernel\Support\Str::studly($name);
        $application = "\\OtkurBiz\\ByteDance\\{$namespace}\\Application";

        return new $application($config);
    }
    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}