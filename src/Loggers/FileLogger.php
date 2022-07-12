<?php

namespace Covery\Client\Loggers;

use Covery\Client\Exception;
use Psr\Log\AbstractLogger;

class FileLogger extends AbstractLogger
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * @param string $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * @param $level
     * @param $message
     * @param array $context
     * @return void
     * @throws Exception
     */
    public function log($level, $message, array $context = array())
    {
        $this->writeLog($level, $message, $context);
    }

    /**
     * @param $level
     * @param $message
     * @param array $context
     * @return void
     * @throws Exception
     */
    private function writeLog($level, $message, array $context = array())
    {
        if (empty($this->filePath)) {
            throw new Exception('file path not set');
        }

        $logContent = $this->formatLogEntry($level, $message, $context);

        file_put_contents($this->filePath, $logContent, FILE_APPEND );
    }

    /**
     * @param string $level
     * @param string $message
     * @param array $context
     * @return string
     */
    private function formatLogEntry($level, $message, array $context)
    {
        return date('Y-m-d H:i:s')
            . " Level: " . $level . PHP_EOL
            . "Message: " . $message . PHP_EOL
            . "Stack trace: " . var_export($context, true) . PHP_EOL;
    }
}
