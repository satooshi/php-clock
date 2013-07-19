php-clock
=========

[![Build Status](https://travis-ci.org/satooshi/php-clock.png?branch=master)](https://travis-ci.org/satooshi/php-clock)
[![Coverage Status](https://coveralls.io/repos/satooshi/php-clock/badge.png)](https://coveralls.io/r/satooshi/php-clock)

Simple clock to get "current datetime" in your web application. "current datetime" means `$_SERVER['REQUEST_TIME']`.

```php
use Satooshi\Component\Clock;

$clock = new Clock();

$datetime = $clock->getCurrentDateTime(); // -> \DateTime
$timestamp = $clock->getUnixTimestamp(); // -> 1374127307
$dbValue = "$clock"; // -> "2013-07-18 06:01:47"
```
