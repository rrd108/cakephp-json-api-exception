<?php

declare(strict_types=1);

namespace JsonApiException;

use Cake\Core\Configure;
use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;

/**
 * Plugin for JsonApiException
 */
class Plugin extends BasePlugin
{
    /**
     * Load all the plugin configuration and bootstrap logic.
     *
     * The host application is provided as an argument. This allows you to load
     * additional plugin dependencies, or attach events.
     *
     * @param \Cake\Core\PluginApplicationInterface $app The host application
     * @return void
     */
    public function bootstrap(PluginApplicationInterface $app): void
    {
        Configure::write('Error.exceptionRenderer', 'JsonApiException\Error\JsonApiExceptionRenderer');
    }
}
