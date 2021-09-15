<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

use App\Http\Constant\Code;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-07
 *
 * 刷新token
 */
class RefreshTokenPlatform extends BaseMiddleware
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
    // $token = \JWTAuth::parseToken()->getToken();
    // dd($token);

    // 检查此次请求中是否带有 token，如果没有则抛出异常。
    try
    {
      $this->checkForToken($request);
    }
    catch(UnauthorizedHttpException $e)
    {
      // 请先登录
      return error(Code::TOKEN_EMPTY);
    }

    // 如果Token不能解析的情况下
    try
    {
      // 使用 try 包裹，以捕捉 token 过期所抛出的 TokenExpiredException  异常
      try
      {
        // 检测用户的登录状态，如果正常则通过
        if ($this->auth->parseToken()->authenticate())
        {
          return $next($request);
        }

        // 请先登录
        return error(Code::TOKEN_EMPTY);
      }
      catch (TokenExpiredException $exception)
      {
        // 用户令牌过期，需要重新登录。
        return error(Code::TOKEN_EXPIRED);
      }
    }
    catch(TokenInvalidException $e)
    {
      // 非法账户，无法解析
      return error(Code::TOKEN_NO_VERIFIED);
    }

    // 在响应头中返回新的 token
    return $this->setAuthenticationHeader($next($request), $token);
  }
}
