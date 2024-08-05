<?php

namespace Logger;

use Exception;
use Illuminate\Support\Facades\Log;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Pheanstalk\Pheanstalk;

class BeanstalkHandler extends AbstractProcessingHandler
{
    private $appName;
    private $tube;
    private $host;

    public function __construct(array $config)
    {
        $level = Logger::toMonologLevel($config['level']);

        parent::__construct($level, true);

        $this->appName = config('app.name');
        $this->host = config('beanstalk-logger.host');
        $this->tube = config('beanstalk-logger.tube');
    }

    public function write($record): void
    {
        try {
            $beanstalk = Pheanstalk::create($this->host);
            $beanstalk->useTube($this->tube)->put(json_encode([
                "worker" => $this->appName,
                "level" => $record["level_name"],
                "error" => $record["message"]
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        } catch (Exception $exception) {
            Log::channel('single')->error($exception->getMessage());
        }
    }
}