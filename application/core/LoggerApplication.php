<?php


namespace Application\Core;

use Exception;

class LoggerApplication
{
    protected $level;
    protected $message;
    protected $items = [];
    protected \Monolog\Logger $logger;

    public static function __callStatic($level, $arguments)
    {
        $class = new self();
        $class->startLog();

        if (empty($arguments[0])) {
            throw new Exception("Error on get Log Message");
        }

        $context = !empty($arguments[1]) ? $arguments[1] : [];

        $class->logger->log($level, $arguments[0], $context);
    }

    private function startLog(): void
    {
        $logpath = APPPATH . '/logs/application/'.\Carbon\Carbon::now()->format('Y-m-d') . '.log';

        $this->logger = new \Monolog\Logger("application");
        $this->logger->pushHandler(new \Monolog\Handler\StreamHandler($logpath, \Monolog\Logger::DEBUG));
        if (is_cli()) {
            $this->logger->pushHandler(new \Monolog\Handler\StreamHandler("php://output"));
        }

    }
}