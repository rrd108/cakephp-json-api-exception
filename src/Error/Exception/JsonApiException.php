<?php

namespace JsonApiException\Error\Exception;

use Cake\Datasource\EntityInterface;
use Cake\Http\Exception\BadRequestException;

class JSonApiException extends BadRequestException
{
    protected  $requestErrors;

    public function __construct(EntityInterface $entity, $message = null, $code = 422)
    {
        $this->requestErrors = $entity->getErrors();

        if ($message === null) {
            $message = 'Bad Request';
        }

        parent::__construct($message, $code);
    }

    public function getRequestErrors()
    {
        return $this->requestErrors;
    }
}