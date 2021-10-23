<?php

namespace JsonApiException\Error;

use Cake\Error\ExceptionRenderer;

class JsonApiExceptionRenderer extends ExceptionRenderer
{
    public function jsonApi($exception)
    {
        $response = $this->controller->getResponse();
        return $response
            ->withStringBody(json_encode(['errors' => $exception->getRequestErrors()]))
            ->withStatus(406)
            ->withType('application/json');
    }
}
