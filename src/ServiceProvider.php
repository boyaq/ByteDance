<?php

namespace OtkruBiz\ByteDance;

use OtkurBiz\ByteDance\Factory;
use OtkurBiz\ByteDance\MiniProgram\Application as MiniProgram;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;
class ServiceProvider extends LaravelServiceProvider
{
    protected $defer = true;

    /**
     * Boot the provider.
     */
    public function boot()
    {
    }

    /**
     * Setup the config.
     */
    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/config/bytedance.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('bytedance.php')], 'bytedance');
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('bytedance');
        }

        $this->mergeConfigFrom($source, 'bytedance');
    }

    /**
     * Register the provider.
     */
    public function register()
    {
        $this->setupConfig();

        $apps = [
            'mini_program' => MiniProgram::class,
        ];

        foreach ($apps as $name => $class) {
            if (empty(config('bytedance.'.$name))) {
                continue;
            }

            if (!empty(config('bytedance.'.$name.'.app_id')) ) {
                $accounts = [
                    'default' => config('bytedance.'.$name),
                ];
                config(['bytedance.'.$name.'.default' => $accounts['default']]);
            } else {
                $accounts = config('bytedance.'.$name);
            }

            foreach ($accounts as $account => $config) {
                $this->app->singleton("bytedance.{$name}.{$account}", function ($laravelApp) use ($name, $account, $config, $class) {
                    $app = new $class(array_merge(config('bytedance.defaults', []), $config));
                    if (config('bytedance.defaults.use_laravel_cache')) {
                        $app['cache'] = $laravelApp['cache.store'];
                    }
                    $app['request'] = $laravelApp['request'];

                    return $app;
                });
            }
            $this->app->alias("bytedance.{$name}.default", 'bytedance.'.$name);

            $this->app->alias('bytedance.'.$name, $class);
        }
    }
}