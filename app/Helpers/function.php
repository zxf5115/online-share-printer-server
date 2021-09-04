<?php
use App\Http\Constant\Code;



/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-31
 * ------------------------------------------
 * 无限制分类
 * ------------------------------------------
 *
 * 无限制分类
 *
 * @param array $list [description]
 * @param string $id 当前节点名字
 * @param string $pid 上级节点名字
 * @param string $child 子节点名字
 * @param integer $root 根节点数值
 * @return [type]
 */
function tree($list = [], $id = 'id', $pid = 'parent_id', $child = 'child', $root = 0)
{
  // 创建Tree
  $response = [];

  if(is_array($list))
  {
    // 创建基于主键的数组引用
    $refer = [];

    foreach ($list as $key => $data)
    {
      $refer[$data[$id]] = &$list[$key];
    }

    //转出ID对内容
    foreach ($list as $key => $data)
    {
      // 判断是否存在parent
      $parent_id = $data[$pid];

      if ($root == $parent_id)
      {
        $response[] =& $list[$key];
      }
      else
      {
        if(isset($refer[$parent_id]))
        {
          $parent = &$refer[$parent_id];
          $parent[$child][] = &$list[$key];
        }
      }
    }
  }

  return $response;
}


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-08-20
 * ------------------------------------------
 * 第三方接口请求
 * ------------------------------------------
 *
 * 第三方接口请求
 *
 * @param [type] $url 请求地址
 * @param array $data post数据
 * @return [type]
 */
function curl($url, $data = [])
{
  $ch = curl_init();

  curl_setopt($ch,CURLOPT_URL, $url);

  if(!empty($data))
  {
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  }

  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_TIMEOUT, 60);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

  if(curl_exec($ch) === false)
  {
    record(curl_error($ch));
  }

  $output = curl_exec($ch);

  $info = curl_getinfo($ch);

  curl_close($ch);

  return $output;
}



/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-12-28
 *
 * 本地环境下进行日志输出
 *
 * @param    [object]     $exception    [异常对象]
 *
 * @return   [false|错误]
 */
function record($exception)
{
  if('local' == config('app.debug'))
  {
    dd($exception);
  }
  else
  {
    \Log::debug($exception);
  }
}


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-26
 * ------------------------------------------
 * 成功信息
 * ------------------------------------------
 *
 * 返回成功信息
 *
 * @param array $data [数据信息]
 * @return 成功信息
 */
function success($data = [], $message = '')
{
  $code = Code::SUCCESS;

  $headers = ['content-type' => 'application/json'];

  $result = [
    'status'  => $code,
    'message' => $message ?: Code::message($code),
    'data'    => $data
  ];

  $response = \Response::json();

  return $response->withHeaders($headers);
}


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-01-19
 * ------------------------------------------
 * 失败信息
 * ------------------------------------------
 *
 * 返回错误信息
 *
 * @param integer $code 错误代码
 * @return 错误信息
 */
function error($code = 1000)
{
  $headers = ['content-type' => 'application/json'];

  $result = [
    'status' => $code,
    'message' => Code::message($code)
  ];

  $response = \Response::json($result);

  return $response->withHeaders($headers);
}



/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-07-26
 * ------------------------------------------
 * 自定义信息
 * ------------------------------------------
 *
 * 返回自定义信息
 *
 * @param integer $code 错误代码
 * @return 错误信息
 */
function message($message)
{
  $headers = ['content-type' => 'application/json'];

  $response = \Response::json(['status' => 0, 'message' => $message]);

  return $response->withHeaders($headers);
}
