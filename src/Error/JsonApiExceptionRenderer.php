<?php

namespace JsonApiException\Error;

use Cake\Utility\Hash;
use Cake\Error\ExceptionRenderer;
use JsonApiException\Error\Exception\JsonApiException;

class JsonApiExceptionRenderer extends ExceptionRenderer
{
    public function jsonApi(JsonApiException $error)
    {
        $errors = $error->getRequestErrors();
        $errorsCount = 0;
        foreach ($errors as $err) {
            if (count($err)) {
                $errorsCount++;
            }
        }

        $response = $this->controller->getResponse();
        $data = [
            'message' => $error->getMessage(),
            'url' =>  $this->controller->getRequest()->getRequestTarget(),
            'line' => $error->getLine(),
            'errorCount' => $errorsCount,
            'errors' => $errors,
        ];

        return $response
            ->withAddedHeader('Access-Control-Allow-Origin', '*')
            ->withStringBody(json_encode($data))
            ->withStatus($error->getCode())
            ->withType('application/json');
    }
}
