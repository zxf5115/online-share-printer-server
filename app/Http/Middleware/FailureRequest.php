<?php
namespace App\Http\Middleware;

use Closure;
use App\Http\Constant\Code;
use App\Models\Api\Module\Member;

/**
 * 会员失效
 */
class FailureRequest
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-03-19
   * ------------------------------------------
   * 监听会员是否失效
   * ------------------------------------------
   *
   * 监听会员是否失效
   *
   * @param [type] $request [description]
   * @param Closure $next [description]
   * @return [type]
   */
  public function handle($request, Closure $next)
  {
    try
    {
      $where = [
        'id'     => auth()->user()->id,
        'status' => 1
      ];

      $result = Member::getRow($where);

      if(empty($result->id))
      {
        return error(Code::TOKEN_EXPIRED);
      }

      return $next($request);
    }
    catch(\Exception $e)
    {
      record($e);
    }
  }
}
