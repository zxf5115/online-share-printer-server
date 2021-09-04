<?php
namespace App\Models\Api\System;

use App\Enum\MessageEnum;
use App\Models\Common\System\User;
use App\Models\Common\System\Message as Common;
use App\Models\Common\System\User\UserRoleRelevance;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-17
 *
 * 系统消息模型类
 */
class Message extends Common
{



  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-07-17
   * ------------------------------------------
   * 消息类型属性类型转换函数
   * ------------------------------------------
   *
   * 消息类型属性类型转换函数
   *
   * @param int $value [数据库存在的值]
   * @return 消息类型
   */
  public function getTypeAttribute($value)
  {
    return MessageEnum::getTypeStatus($value);
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-02-23
   * ------------------------------------------
   * 获取消息文本列表
   * ------------------------------------------
   *
   * 获取消息文本列表
   *
   * @return [type]
   */
  public static function getTypeTextList()
  {
    return MessageEnum::getTypeText();
  }

  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-02-26
   * ------------------------------------------
   * 直接获取推送用户
   * ------------------------------------------
   *
   * 直接获取推送用户
   *
   * @param object $request [请求数据]
   * @return 推送用户
   */
  public static function getUsers($request, $current_id, $organization_id)
  {
    if($request->type != 3 && 'user' == $request->accept_type)
    {
      $users = self::getWithUserUsers($request->user_list, $current_id, $organization_id);
    }
    else if($request->type != 3 && 'role' == $request->accept_type)
    {
      $users = self::getWithRoleUsers($request->role_list, $current_id, $organization_id);
    }
    else
    {
      $users = self::getAllUserId($current_id, $organization_id);
    }

    return $users;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-02-26
   * ------------------------------------------
   * 直接获取推送用户
   * ------------------------------------------
   *
   * 根据推送类型为用户，直接获取推送用户
   *
   * @param　array $user_list [用户列表]
   * @return 推送用户列表
   */
  public static function getWithUserUsers($user_list, $current_id, $organization_id)
  {
    $users = [];

    foreach($user_list as $user)
    {
      if(0 < $user && $current_id != $user)
      {
        $users[] = ['user_id' => $user, 'organization_id' => $organization_id];
      }
    }

    return $users;
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-02-26
   * ------------------------------------------
   * 通过角色查询获取推送用户
   * ------------------------------------------
   *
   * 根据推送类型为角色，通过角色查询获取推送用户
   *
   * @param [type] $role_list [角色列表]
   * @return 推送用户列表
   */
  public static function getWithRoleUsers($role_list, $current_id, $organization_id)
  {
    $response = UserRoleRelevance::whereIn('role_id', $role_list)->get('user_id')->toArray();

    foreach($response as $key => $item)
    {
      if($current_id != $item['user_id'])
      {
        $response[$key]['organization_id'] = $organization_id;
      }
    }

    return $response;
  }


  public static function getAllUserId($current_id, $organization_id)
  {
    $response = User::where(['status' => 1])->where('id', '!=',$current_id)->get('id as user_id')->toArray();

    foreach($response as $key => $item)
    {
      $response[$key]['organization_id'] = $organization_id;
    }

    return $response;
  }
}
