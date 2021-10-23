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

or manually add the following line to your app's `src/Application.php `file's `bootstrap()` function:

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
