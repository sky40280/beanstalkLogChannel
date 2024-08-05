
# Laravel Beanstalk logger

Send log message as a job to beanstalk

## Install

```

composer require sky40280/beanstalk-logger-channel

```

Add to <b>.env</b>

```
BEANSTALKD_HOST=127.0.0.1
BEANSTALKD_JOB_TUBE=laravel-log
```


Add to <b>config/logging.php</b> file new channel:

```php
'beanstalk' => [
    'driver' => 'custom',
    'via'    => Logger\BeanstalkJobLogger::class,
    'level'  => 'debug',
]
```

Add to config/beanstalk-logger.php

```php
<?php

return [
    // Beanstalk host
    'host' => env('BEANSTALKD_HOST', '127.0.0.1'),

    // Beanstalk tube
    'tube' => env('BEANSTALKD_JOB_TUBE', 'laravel-log'),
];
```

If your default log channel is a stack, you can add it to the <b>stack</b> channel like this
```php
'stack' => [
    'driver' => 'stack',
    'channels' => ['single', 'beanstalk'],
]
```