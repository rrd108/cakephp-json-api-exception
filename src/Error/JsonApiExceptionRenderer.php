<?php

namespace JsonApiException\Error;

use Cake\Utility\Hash;
use Cake\Error\ExceptionRenderer;
use JsonApiException\Error\Exception\JsonApiException;

class JsonApiExceptionRenderer extends ExceptionRenderer
{
    public function jsonApi(JsonApiException $error)
    {
        $response = $this->controller->getResponse();
        $data = [
            'message' => $error->getMessage(),
            'url' =>  $this->controller->getRequest()->getRequestTarget(),
            'line' => $error->getLine(),
            'errorCount' => count(Hash::flatten($error->getRequestErrors())),
            'errors' => $error->getRequestErrors(),
        ];

        return $response
            ->withAddedHeader('Access-Control-Allow-Origin', '*')
            ->withStringBody(json_encode($data))
            ->withStatus($error->getCode())
            ->withType('application/json');
    }
}
