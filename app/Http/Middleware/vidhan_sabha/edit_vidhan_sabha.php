<?php

namespace App\Http\Middleware\vidhan_sabha;

use Closure;
use Auth;
use DB;

class edit_vidhan_sabha
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
      $check =  DB::table('manage_role')
                 ->where('user_types_id',Auth()->user()->role_id)
                 ->where('edit_vidhan_sabha',1)
                 ->first();
        if($check == null){
          return  redirect('not_allowed');
        }else{
          return $next($request);
        }
    }
}
