# bit.ly URL shortener API

## Install
```bash
$ composer require dominikveils/bitly
```

## Usage
```php
<?php

require 'vendor/autoload.php';

$bitly = new DominikVeils\Bitly\Bitly('API KEY');

$short_url =  $bitly->shorten('https://google.com');
echo "SHORT URL: {$short_url}", PHP_EOL;
$long_url = $bitly->expand($short_url);
echo "LONG URL: {$long_url}", PHP_EOL;
```

## LICENSE
MIT