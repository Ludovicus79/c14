<?php

namespace App\Bootstrap;

use Illuminate\Foundation\Bootstrap\HandleExceptions as BaseHandleExceptions;

class HandleExceptions extends BaseHandleExceptions
{
    public function handleError($level, $message, $file = '', $line = 0, $context = [])
    {
        // Ignore deprecation notices on PHP 8.2+ (Laravel 6 compatibility)
        if ($level === E_DEPRECATED || $level === E_USER_DEPRECATED) {
            return;
        }

        parent::handleError($level, $message, $file, $line, $context);
    }
}
