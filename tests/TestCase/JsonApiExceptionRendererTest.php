<?php

namespace JsonApiException\Test\TestCase;

use Cake\ORM\Entity;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use JsonApiException\Error\JsonApiExceptionRenderer;
use JsonApiException\Error\Exception\JsonApiException;

class JsonApiExceptionRendererTest extends TestCase
{
    protected $message = 'Save failed';
    protected $validationError = 'name is required';

    public function testJsonApiWithEntityError()
    {
        $entity = new Entity();
        $entity->setError('name', ['_empty' => $this->validationError]);
        $exception = new JsonApiException($entity, $this->message);

        $request = (new ServerRequest())
            ->withParam('controller', 'Foo')
            ->withParam('action', 'bar');
        $exceptionRenderer = new JsonApiExceptionRenderer($exception, $request);

        $response = $exceptionRenderer->render();

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getType());

        $responseBody = json_decode($response->__toString());
        $this->assertEquals($this->message, $responseBody->message);
        $this->assertEquals('/', $responseBody->url);
        $this->assertEquals(1, $responseBody->errorCount);
        $this->assertEquals($this->validationError, $responseBody->errors->name->_empty);
    }

    public function testJsonApiWithErrorCode()
    {
        $entity = new Entity();
        $entity->setError('name', ['_empty' => $this->validationError]);
        $exception = new JsonApiException($entity, $this->message, 406);

        $request = (new ServerRequest())
            ->withParam('controller', 'Foo')
            ->withParam('action', 'bar');
        $exceptionRenderer = new JsonApiExceptionRenderer($exception, $request);

        $response = $exceptionRenderer->render();

        $this->assertEquals(406, $response->getStatusCode());
    }
}
