<?php
namespace App\Http\Constant;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-07-15
 *
 * Redis 键值常量类
 */
class RedisKey
{
  // 平台核心数据
  const KERNEL = 'currency_kernel';

  // 系统协议
  const AGREEMENT = 'currency_agreement';

  // 平台菜单键名
  const PLATFORM_MENU = 'currency_platform_menus';


  // 短信登录验证码键名
  const SMS_LOGIN_CODE = 'currency_sms_login_code';

  // 短信注册验证码键名
  const SMS_REGISTERR_CODE = 'currency_sms_registere_code';

  // 短信绑定验证码键名
  const SMS_BIND_CODE = 'currency_sms_bind_code';

  // 短信重置验证码键名
  const SMS_RESET_CODE = 'currency_sms_reset_code';

  // 短信修改验证码键名
  const SMS_CHANGE_CODE = 'currency_sms_change_code';


}
