<?php

namespace Opensource\TestPlugin;

use Illuminate\Support\ServiceProvider;

class TestPluginServiceProvider extends ServiceProvider
{
    /**
     * Publishes configuration file.
     *
     * @return  void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/test_plugin.php' => config_path('test_plugin.php'),
        ], 'test_plugin_config');
    }

    /**
     * Make config publishment optional by merging the config from the package.
     *
     * @return  void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/test_plugin.php',
            'test_plugin'
        );
    }
}