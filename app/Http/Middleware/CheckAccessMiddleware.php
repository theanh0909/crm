<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Transaction;

class CheckAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        $userId = auth()->user()->id;
        $level = auth()->user()->level; // 1 = quyền cao nhất
        $check = Transaction::where('name_upload', $request->nameUpload)->first();

        if ($check->user_request_id == $userId || $level == 1) {
            return $next($request);
        } else {
            return back()->with('error', 'Bạn chỉ được phép truy cập vào đợt upload của bạn');
        }
    }
}
