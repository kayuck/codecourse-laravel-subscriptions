<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NotSubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /* ログインしてて、subscribeしてる人はサブスクの管理ページに飛ばす */
        if($request->user() && $request->user()->subscribed('default')){
            return redirect()->route('account.subscriptions');
        }
        return $next($request);
    }
}
