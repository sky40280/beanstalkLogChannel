<?php

namespace Logger;

use Monolog\Logger;

class BeanstalkLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        return new Logger(
            config('app.name'),
            [
                new BeanstalkHandler($config),
            ]
        );
    }
}