<?php

namespace JsonApiException\Error\Exception;

use Cake\Datasource\EntityInterface;
use Cake\Http\Exception\BadRequestException;

class JsonApiException extends BadRequestException
{
    protected  $requestErrors;

    public function __construct(EntityInterface|array $entity, $message = null, $code = 400)
    {
        if (is_array($entity)) {
            foreach ($entity as $ent) {
                $this->requestErrors[] = $ent->getErrors();
            }
        }
        if (!is_array($entity)) {
            $this->requestErrors = $entity->getErrors();
        }

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
