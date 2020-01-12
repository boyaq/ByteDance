<?php
/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace OtkurBiz\ByteDance\Kernel\Traits;

use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Cache\FilesystemCache;
use OtkurBiz\ByteDance\Kernel\ServiceContainer;
use Psr\SimpleCache\CacheInterface;

/**
 * Trait InteractsWithCache.
 *
 * @author overtrue <i@overtrue.me>
 */
trait InteractsWithCache
{
    /**
     * @var \Psr\SimpleCache\CacheInterface
     */
    protected $cache;

    /**
     * Get cache instance.
     *
     * @return \Psr\SimpleCache\CacheInterface
     */
    public function getCache()
    {
        if ($this->cache) {
            return $this->cache;
        }
        if (property_exists($this, 'app') && $this->app instanceof ServiceContainer
            && isset($this->app['cache']) && $this->app['cache'] instanceof CacheInterface) {
            return $this->cache = $this->app['cache'];
        }

        return $this->cache = $this->createDefaultCache();
    }

    /**
     * Set cache instance.
     *
     * @param \Psr\SimpleCache\CacheInterface $cache
     *
     * @return $this
     */
    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * @return \Symfony\Component\Cache\Simple\FilesystemCache
     */
    protected function createDefaultCache()
    {
        return new FilesystemCache(sys_get_temp_dir());
    }
}
