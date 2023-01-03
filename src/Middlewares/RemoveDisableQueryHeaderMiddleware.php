<?php

namespace Cirelramos\Cache\Middlewares;

use Closure;
use Cirelramos\Cache\Models\ModelCacheConst;

/**
 *
 */
class RemoveDisableQueryHeaderMiddleware
{
    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $request->headers->remove(ModelCacheConst::HEADER_ACTIVE_RECORD);
        $request->headers->remove(ModelCacheConst::HEADER_MODE_JOB);
        return $next($request);
    }
}





