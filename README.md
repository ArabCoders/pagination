# Pagination

Pagination..

## Install

Via Composer

```bash
$ composer require arabcoders/pagination
```

## Usage Example.

```php
<?php

require __DIR__ . '/../../autoload.php';

$renderer = new \arabcoders\pagination\Renderer\HTML();

$pagination = ( new \arabcoders\pagination\Pagination( $renderer ) )->setItems( 50 ,1 ,10 );

echo $pagination->render();
```
