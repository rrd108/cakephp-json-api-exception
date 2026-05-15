<?php

namespace JsonApiException\Test\TestCase;

use Cake\TestSuite\TestCase;
use JsonApiException\JsonApiExceptionPlugin;
use JsonApiException\Plugin;

class JsonApiExceptionPluginTest extends TestCase
{
    public function testPluginExtendsBasePlugin(): void
    {
        $plugin = new JsonApiExceptionPlugin();
        $this->assertInstanceOf('Cake\Core\BasePlugin', $plugin);
    }

    public function testBcShimExtendsNewPlugin(): void
    {
        $plugin = new Plugin();
        $this->assertInstanceOf(JsonApiExceptionPlugin::class, $plugin);
    }

    public function testPluginName(): void
    {
        $plugin = new JsonApiExceptionPlugin();
        $this->assertSame('JsonApiException', $plugin->getName());
    }
}
