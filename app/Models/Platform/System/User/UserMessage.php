<?php
namespace App\Models\Platform\System\User;

use App\Models\Common\System\User\UserMessage as Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-04-16
 *
 * 系统用户消息模型类
 */
class UserMessage extends Common
{
  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-16
   * ------------------------------------------
   * 设置为已读消息
   * ------------------------------------------
   *
   * 设置为已读消息
   *
   * @param int $id [消息id]
   */
  public static function setReaded($id, $current_id)
  {
    try
    {
      $model = self::where(['user_id' => $current_id]);

      // id 为0时表示为全部已读
      if($id > 0)
      {
        $model->where(['id' => $id]);
      }

      return $model->update(['status' => 2]);
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2021-04-16
   * ------------------------------------------
   * 删除全部已读消息
   * ------------------------------------------
   *
   * 删除全部已读消息
   *
   * @param int $id [消息id]
   */
  public static function setDelete($id, $current_id)
  {
    try
    {
      $model = self::where(['user_id' => $current_id]);

      // id 为0时表示为全部删除
      if($id > 0)
      {
        $model->where(['id' => $id]);
      }

      return $model->delete();
    }
    catch(\Exception $e)
    {
      record($e);

      return false;
    }
  }
}
