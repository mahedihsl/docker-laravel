<?php

namespace App\Helpers;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Carbon\Carbon;

class FileLogger extends Logger
{
    protected $path = null;

    public function __construct($name, $level = 'DEBUG', $path = null, array $processors = [ ])
    {
        $tz = static::$timezone = new \DateTimeZone(config('app.timezone'));
        $handlers = [ ];
        parent::__construct($name, $handlers, $processors);

        $dtObj = Carbon::now($tz);

        if ( ! $path) {
            $path = $name . '-' . $dtObj->format('Y-m-d') . '.log';
        }

        $path = $this->path = storage_path('logs/' . $path);

        $this->addStream($path, $level);

        return $this;
    }

    public static function getLevelNum($level)
    {
        return static::getLevels()[ strtoupper($level) ];
    }

    public function addStream($path, $level = 'DEBUG')
    {
        if ( ! is_int($level)) {
            $level = static::getLevelNum($level);
        }
        $this->pushHandler(new StreamHandler($path, $level));

        return $this;
    }

    public function addRecord($level, $message, array $context = array())
    {
        if ( ! is_int($level)) {
            $level = static::getLevelNum($level);
        }

        parent::addRecord($level, $message, $context);

        return $this;
    }
}
