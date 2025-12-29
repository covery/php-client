<?php

namespace Covery\Client\Loggers;

use \Psr\Log\AbstractLogger;
use Stringable;

/**
 * Simple var dump logger
 */
class VarDumpLogger extends AbstractLogger
{
    /**
     * @param $level
     * @param $message
     * @param array $context
     * @return void
     */
    public function log($level, string|Stringable $message, array $context = []): void
    {
        var_dump([
            'level' => $level,
            'message' => $message,
            'context' => $context
        ]);
    }
}
