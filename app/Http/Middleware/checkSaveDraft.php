<?php

namespace App\Http\Middleware;

use App\Models\Well;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkSaveDraft
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $well=$request->well();
        if($well->published=='last_draft'){
            return abort(405);
        }
        return $next($request);
    }
}
