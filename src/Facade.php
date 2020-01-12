<?php

/*
 * This file is part of the otkurbiz/bytedance.
 *
 * (c) alim <alim@bulutbazar.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace OtkurBiz\ByteDance;

use Illuminate\Support\Facades\Facade as LaravelFacade;

/**
 * Class Facade.
 *
 * @author alim <alim@bulutbazar.com>
 */
class Facade extends LaravelFacade
{
    /**
     * 默认为 Server.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'bytedance.mini_program';
    }

    /**
     * @return \OtkurBiz\ByteDance\MiniProgram\Application
     */
    public static function miniProgram($name = '')
    {
        return $name ? app('bytedance.mini_program.'.$name) : app('bytedance.mini_program');
    }
}
