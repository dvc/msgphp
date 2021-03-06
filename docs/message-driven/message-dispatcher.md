# Message dispatcher

The domain message dispatcher is a utility trait. Its purpose is to dispatch a factorized message object using a
[object factory](../ddd/factory/object.md) and a [message bus](message-bus.md).

## API

### `dispatch(string $class, array $context = []): mixed`

Dispatches a message object factorized from `$class` and `$context`. The dispatcher can return a value coming from
handlers, but is not required to do so.

## Basic example

```php
<?php

use MsgPhp\Domain\Message\MessageDispatchingTrait;

class MyMessage
{
    public $argument;

    public function __construct(string $argument)
    {
        $this->argument = $argument;
    }
}

class MyClass
{
    use MessageDispatchingTrait;

    public function doSomething(): void
    {
        $this->dispatch(MyMessage::class, ['argument' => 'value']);
    }
}
```
