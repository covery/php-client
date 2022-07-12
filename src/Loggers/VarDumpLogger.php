<?php

namespace Covery\Client\Loggers;

use \Psr\Log\AbstractLogger;

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
    public function log($level, $message, array $context = array())
    {
        var_dump([
            'level' => $level,
            'message' => $message,
            'context' => $context
        ]);
    }
}
