<?php

namespace App\Http\Middleware;
use Closure;
use App\Helpers\FileLogger;
use App\Service\Log\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Routing\TerminableMiddleware;
use Carbon\Carbon;

class LogMiddleware
{
    private $logger;

    public function __construct()
    {
      
    }

    public function handle($request, Closure $next)
    {
      
      return $next($request);
    }

    public function terminate($request, $response)
    {
      
    }
}
