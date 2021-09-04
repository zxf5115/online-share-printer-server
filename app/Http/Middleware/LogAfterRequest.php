<?php
namespace App\Http\Middleware;

use Closure;

class LogAfterRequest
{
  public function handle($request, Closure $next)
  {
    $start = microtime(true);

    $request->headers->set('X-Request-Start-Time', $start);

    return $next($request);
  }

  public function terminate($request, $response)
  {
    $start = $request->headers->get('X-Request-Start-Time');
    $end = microtime(true);

    $username = auth()->user()->nickname;

    // $log = new Action();
    // $log->username       = $username;
    // $log->operation      = $username . '进行了登录操作';
    // $log->method         = $request->method();
    // $log->params         = json_encode($request->all());
    // $log->execution_time = number_format(($end - $start) * 1000, 3); // milliseconds
    // $log->ip_address     = ip2long($request->ip());

    // $log->save();
  }
}
