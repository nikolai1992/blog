<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
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
        //находит есть ли зарегистрированный пользователь
        if ($request->user() === null) {
            return redirect("/login");
        }

        /** Get array from routes **/

        //получает текущий роут
        //получаем массив 2 посредников - web - из MiddlewareGroups
        //и наш roles который мы указали
        $actions = $request->route()->getAction();
        /** Get array from middleware **/
        $middleware = $request->route()->getController()->getMiddleware();

        /**
         * Find if there is some roles for the route
         */

        $action_roles = isset($actions['roles']) ? $actions['roles'] : array();
        $middleware_roles = isset($middleware[0]['options'])? $middleware[0]['options'] : array();

        $roles = array_merge ($action_roles, $middleware_roles);

        /**
         * Check if user has any of roles or if roles dont set for this route
         */

        if ($request->user()->hasAnyRole($roles))
        {
            return $next($request);
        }else {
            return redirect('/');
        }
    }
}
