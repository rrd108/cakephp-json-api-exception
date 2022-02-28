# JsonApiException plugin for CakePHP

Make your CakePHP 4 JSON REST API response more descriptive on errors.

If you want a simple solution for token authentication for a CakePHP JSON REST API, then check this: [CakePHP API Token Authenticator](https://github.com/rrd108/api-token-authenticator)

## Installation

You can install this plugin into your CakePHP application using [composer](https://getcomposer.org).

The recommended way to install is:

```
composer require rrd108/cakephp-json-api-exception
```

Then, to load the plugin either run the following command:

```
bin/cake plugin load JsonApiException
```

or manually add the following line to your app's `src/Application.php` file's `bootstrap()` function:

```php
$this->addPlugin('JsonApiException');
```

done :)

## How to use

Assuming you have a CakePHP JSON REST API and you want to have more informative error messages and proper response codes.

```php
// for example in /src/Controller/UsersController.php slightly change the baked add function
use JsonApiException\Error\Exception\JsonApiException;

public function add()
{
    $user = $this->Users->newEmptyEntity();
    if ($this->request->is('post')) {
        $user = $this->Users->patchEntity($user, $this->request->getData());
        if (!$this->Users->save($user)) {
            throw new JsonApiException($user, 'Save failed');
            // throw new JsonApiException($user, 'Save failed', 418);   // you can set the response's status code in the 3rd parameter
        }
    }
    $this->set(compact('user'));
    $this->viewBuilder()->setOption('serialize', ['user']);
}
```

If the save failed you will get a response like this.

```json
{
  "message": "Save failed",
  "url": "/users.json",
  "line": 12,
  "errorCount": 1,
  "errors": {
    "password": {
      "_required": "This field is required"
    }
  }
}
```

You can us it with an array of entities also.

```php
// for example in /src/Controller/UsersController.php slightly change the baked add function
use JsonApiException\Error\Exception\JsonApiException;

public function bulkAdd()
{
    $users = $this->Users->newEntities($this->request->getData());
    if (!$this->Users->saveMany($users)) {
        throw new JsonApiException($users, 'Errors in request data');
    }
    $this->set(compact('users'));
    $this->viewBuilder()->setOption('serialize', ['users']);
}
```

If the save failed you will get a response like this.
As at this point we do not have an `id` for the entity, the error messages can not contain it. So an empty array will be present in the `errors` array if an entity does not have any errors. So the number of the entity will match the number of the error entries, entity #3's error message will be the third element of the error array.

```json
{
  "message": "Errors in request data",
  "url": "/users.json",
  "line": 12,
  "errorCount": 2,
  "errors": [
    {
      "name": {
        "_empty": "name is required"
      }
    },
    {
      "name": {
        "_empty": "name is required"
      }
    }
  ]
}
```
