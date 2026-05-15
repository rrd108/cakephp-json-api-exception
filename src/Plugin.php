<?php

declare(strict_types=1);

namespace JsonApiException;

/**
 * Backwards-compatibility shim for CakePHP ≤5.2.
 *
 * CakePHP 5.3+ deprecates plugin classes named `Plugin` and expects
 * the class to be named after the plugin (e.g. `JsonApiExceptionPlugin`).
 * This class exists so that users on CakePHP ≤5.2 can still load
 * the plugin as `$this->addPlugin('JsonApiException')` without changes.
 *
 * @deprecated Use JsonApiExceptionPlugin instead. Will be removed in next major release.
 */
class Plugin extends JsonApiExceptionPlugin
{
}
