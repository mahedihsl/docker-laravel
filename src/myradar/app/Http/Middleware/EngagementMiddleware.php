<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Entities\Activity;
use App\Contract\Repositories\ActivityRepository;
use App\Criteria\UserIdCriteria;
use App\Criteria\ExactDateCriteria;

class EngagementMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        if ($user = $request->user()) {
            if ($request->is('api/billing/status')) {
                $this->engage($user->id, TRUE);
            } else $this->engage($user->id);
        }


    }

    public function engage($userid, $login = FALSE)
    {
        $when = Carbon::today();

        $repo = resolve(ActivityRepository::class);
        $record = $repo->pushCriteria(new ExactDateCriteria($when))
                    ->pushCriteria(new UserIdCriteria($userid))
                    ->first();

        if (is_null($record)) {
            $repo->create([
                'login' => intval($login),
                'request' => intval(!$login),
                'user_id' => $userid,
                'when' => $when,
            ]);
        } else $record->increment($login ? 'login' : 'request', 1);
    }
}
