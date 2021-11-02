<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Gate;

class AccessAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

if(Gate::allows('is-admin')){
    // $users = User::paginate(10);
    //   return view('admin.users.index',['users'=>$users]);
    return $next($request);

}


    }
}
