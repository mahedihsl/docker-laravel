<?php

namespace App\Http\Middleware;
use Closure;
use App\Helpers\FileLogger;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Routing\TerminableMiddleware;
use Carbon\Carbon;
use App\Entities\ExecTime;

class QueryLog
{
    private $logger;

    private $startTime;

    public function __construct()
    {
      
    }

    public function handle($request, Closure $next)
    {
        // $this->startTime = round(microtime(true) * 1000);
        
        // DB::connection( 'mongodb' )->enableQueryLog();
        
        return $next($request);
    }

    public function terminate($request, $response)
    {
      // $end = round(microtime(true) * 1000);

      // ExecTime::create([
      //   'device' => 0,
      //   'time' => $end - $this->startTime,
      // ]);

      // $path = $request->path();
      // $endTime = microtime();

      // if (strpos($path, 'car/last/position') == FALSE) {
      //   return;
      // }
      
      // $logs = DB::connection('mongodb')->getQueryLog();
      // $time = collect($logs)->reduce(function($carry, $item) {
      //   return $carry + $item['time'];
      // }, 0.0);

    }
}
