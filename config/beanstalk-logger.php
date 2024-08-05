<?php

return [
    // Beanstalk host
    'host' => env('BEANSTALKD_HOST', '127.0.0.1'),

    // Beanstalk tube
    'tube' => env('BEANSTALKD_JOB_TUBE', 'laravel-log'),
];