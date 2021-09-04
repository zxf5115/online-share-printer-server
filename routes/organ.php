<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Organ')->middleware('cors')->group(function() {

  // 核心功能
  Route::namespace('System')->group(function() {

    // 登录
    Route::post('/login', 'LoginController@login')->name('login');
    Route::post('/sms_login', 'LoginController@sms_login');
    Route::post('/sms_code', 'LoginController@sms_code');

    // 获取系统核心配置信息
    Route::post('/kernel', 'SystemController@kernel');


    // 首页统计数据
    Route::get('/index/get_statistics','IndexController@get_statistics');

    // 注册账号
    Route::get('/register', 'LoginController@register');

    // 清除缓存
    Route::get('/clear', 'LoginController@clear');
    // 注销账号
    Route::get('/logout', 'LoginController@logout');
    // 验证是否登录
    Route::get('/check_user_login', 'LoginController@check_user_login');
    // 后台用户
    Route::get('/get_user_info','UserController@get_user_info');


    // 系统菜单功能
    Route::prefix('menu')->group(function() {
      Route::get('/list', 'MenuController@list');
      Route::post('/get_bread_nav', 'MenuController@get_bread_nav');
      Route::any('/handle','MenuController@handle');
      Route::any('/view/{id}','MenuController@view');
      Route::any('/select','MenuController@select');
      Route::any('/level','MenuController@level');
      Route::post('/delete', 'MenuController@delete');
    });


    // 文件上传功能
    Route::prefix('file')->group(function() {
      Route::post('/avatar', 'FileController@avatar');
      Route::post('/picture', 'FileController@picture');
      Route::post('/document', 'FileController@document');
    });



    // 系统配置功能
    Route::prefix('config')->group(function() {

      // 配置管理
      Route::any('/list','ConfigController@list');
      Route::get('/view/{id}','ConfigController@view');
      Route::post('/handle', 'ConfigController@handle');
      Route::post('/delete/{id?}', 'ConfigController@delete');

      // 配置分类管理
      Route::namespace('Config')->prefix('category')->group(function() {
        Route::any('/list','CategoryController@list');
        Route::get('/view/{id}','CategoryController@view');
        Route::get('/level','CategoryController@level');
        Route::post('/handle', 'CategoryController@handle');
        Route::post('/delete/{id?}', 'CategoryController@delete');
      });
    });


    Route::prefix('setting')->group(function() {
      // 配置中心
      Route::any('/web', 'SettingController@web'); // 站点设置
      Route::any('/upload', 'SettingController@upload'); // 上传设置
      Route::any('/map', 'SettingController@map'); // 地图设置
      Route::any('/wechat', 'SettingController@wechat'); // 微信公众号配置
      Route::any('/oauth', 'SettingController@oauth'); // 微信Oauth 配置 PC
      Route::any('/distribution', 'SettingController@distribution'); // 分销配置
      Route::any('/task', 'SettingController@task'); // 定时任务 自动执行
      Route::any('/sms', 'SettingController@sms'); // 短信sms
      Route::any('/template', 'SettingController@template'); // 模板消息


      Route::namespace('Setting')->group(function() {
        // 支付配置功能
        Route::any('/pay/wxpay_h5','PayConfigController@wxpay_h5'); // 微信支付H5配置
        Route::any('/pay/wxpay_app','PayConfigController@wxpay_app'); // 微信支付APP配置
        Route::any('/pay/wxpay_js','PayConfigController@wxpay_js'); // 微信支付JSAPI配置
        Route::any('/pay/wxpay_mini','PayConfigController@wxpay_mini'); // 微信支付MINI配置(小程序)
        Route::any('/pay/alipay_h5','PayConfigController@alipay_h5'); // 支付宝支付 H5
        Route::any('/pay/alipay_app','PayConfigController@alipay_app'); // 支付宝支付 App
        Route::any('/pay/alipay_pc','PayConfigController@alipay_pc'); // 支付宝支付 PC

        // 第三方登录配置功能
        Route::any('/oauth/qq','OauthConfigController@qq'); // qq登录配置
        Route::any('/oauth/wechat','OauthConfigController@wechat'); // wechat登录配置
        Route::any('/oauth/weibo','OauthConfigController@weibo'); // weibo登录配置

        // 云存储配置功能
        Route::any('/cloud/aliyun','CloudConfigController@aliyun'); // 阿里云配置
        Route::any('/cloud/qiniu','CloudConfigController@qiniu'); // 七牛云配置

        // 站点协议
        Route::any('/agreement/list','AgreementController@list');
        Route::get('/agreement/view/{id}','AgreementController@view');
        Route::post('/agreement/handle', 'AgreementController@handle');
        Route::post('/agreement/delete/{id?}', 'AgreementController@delete');
      });
    });


    // 系统消息功能
    Route::prefix('message')->group(function() {

      Route::any('/list','messageController@list');
      Route::get('/view/{id}','messageController@view');
      Route::post('/handle', 'messageController@handle');
      Route::get('type', 'MessageController@type');
      Route::post('readed', 'MessageController@readed');
      Route::post('/delete','messageController@delete');
    });


    // 系统会员功能
    Route::prefix('member')->group(function() {
      Route::get('/list','MemberController@list');
      Route::any('/handle','MemberController@handle');
      Route::post('/tree', 'MemberController@tree');
      Route::any('/view/{id}','MemberController@view');
      Route::any('/password','MemberController@password');
      Route::post('/delete','MemberController@delete');
      Route::get('/get_user_info','MemberController@get_user_info'); // 获取用户信息

      // 系统会员角色功能
      Route::namespace('Member')->prefix('role')->group(function() {
        Route::get('/list','RoleController@list');
        Route::any('/handle','RoleController@handle');
        Route::any('/view/{id}','RoleController@view');
        Route::any('/select','RoleController@select');
        Route::any('/permission/{id}','RoleController@permission');
        Route::post('/delete','RoleController@delete');
      });
    });
  });



  // 车队功能
  Route::namespace('Team')->group(function() {

    // 车队
    Route::prefix('team')->group(function() {
      Route::any('/list','TeamController@list');
      Route::get('/view/{id}','TeamController@view');
      Route::get('/select','TeamController@select');
      Route::post('/handle', 'TeamController@handle');
      Route::post('/delete','TeamController@delete');
    });

    // 车辆
    Route::prefix('truck')->group(function() {
      Route::any('/list','TruckController@list');
      Route::get('/view/{id}','TruckController@view');
      Route::get('/player', 'TruckController@player');
      Route::post('/select', 'TruckController@select');
      Route::post('/import', 'TruckController@import');
      Route::post('/handle', 'TruckController@handle');
      Route::post('/delete/{id?}', 'TruckController@delete');
    });

    // 加油
    Route::prefix('fuel')->group(function() {
      Route::any('/list','FuelController@list');
      Route::get('/view/{id}','FuelController@view');
      Route::post('/select', 'FuelController@select');
      Route::post('/handle', 'FuelController@handle');
      Route::post('/delete','FuelController@delete');
    });

    // 维修
    Route::prefix('repair')->group(function() {
      Route::any('/list','RepairController@list');
      Route::get('/view/{id}','RepairController@view');
      Route::post('/select', 'RepairController@select');
      Route::post('/handle', 'RepairController@handle');
      Route::post('/delete','RepairController@delete');
    });
  });


  // 订单管理
  Route::namespace('Order')->prefix('order')->group(function() {

    Route::any('/list','OrderController@list');
    Route::get('/view/{id}','OrderController@view');
    Route::post('/delete/{id?}', 'OrderController@delete');

    // 出车单审核管理
    Route::prefix('audit')->group(function() {
      Route::any('/list','AuditController@list');
      Route::get('/view/{id}','AuditController@view');
      Route::any('/select','AuditController@select');
      Route::post('/handle', 'AuditController@handle');
      Route::post('/change', 'AuditController@change');
      Route::post('/confirm', 'AuditController@confirm');
      Route::post('/delete/{id?}', 'AuditController@delete');
    });


    // 出车单统计管理
    Route::prefix('statistical')->group(function() {
      Route::any('/list','StatisticalController@list');
      Route::get('/view/{id}','StatisticalController@view');
      Route::any('/select','StatisticalController@select');
      Route::get('/withdrawal','StatisticalController@withdrawal');
      Route::post('/handle', 'StatisticalController@handle');
      Route::post('/change', 'StatisticalController@change');
      Route::post('/confirm', 'StatisticalController@confirm');
      Route::post('/delete/{id?}', 'StatisticalController@delete');

      // 结算最终详情管理
      Route::namespace('Relevance')->group(function() {

        // 结算凭证管理
        Route::prefix('ultimate')->group(function() {
          Route::get('/view/{id?}', 'UltimateController@view');
          Route::post('/handle', 'UltimateController@handle');
        });
      });
    });
  });


  // 财务管理
  Route::namespace('Financial')->prefix('financial')->group(function() {

    // 预支工资管理
    Route::prefix('advance')->group(function() {
      Route::any('/list','AdvanceController@list');
      Route::get('/view/{id}','AdvanceController@view');
      Route::post('/handle', 'AdvanceController@handle');
      Route::post('/delete/{id?}', 'AdvanceController@delete');
    });

    // 待发工资管理
    Route::prefix('wait')->group(function() {
      Route::any('/list','WaitController@list');
      Route::get('/view/{id}','WaitController@view');
      Route::any('/select','WaitController@select');
      Route::post('/handle', 'WaitController@handle');
      Route::post('/delete/{id?}', 'WaitController@delete');
    });

    // 已发工资管理
    Route::prefix('already')->group(function() {
      Route::any('/list','AlreadyController@list');
      Route::post('/view','AlreadyController@detail');
      Route::any('/select','AlreadyController@select');
      Route::any('/detail_select','AlreadyController@detail_select');
      Route::post('/handle', 'AlreadyController@handle');
      Route::post('/delete/{id?}', 'AlreadyController@delete');
    });

    // 财务报表管理
    Route::prefix('statement')->group(function() {
      Route::any('/list','StatementController@list');
      Route::post('/select','StatementController@select');
    });
  });


  // 结算管理
  Route::namespace('Settlement')->prefix('settlement')->group(function() {

    // 待结算管理
    Route::prefix('audit')->group(function() {
      Route::any('/list','AuditController@list');
      Route::get('/view/{id}','AuditController@view');
      Route::get('/select','AuditController@select');
      Route::post('/handle', 'AuditController@handle');
      Route::post('/confirm', 'AuditController@confirm');
      Route::post('/delete/{id?}', 'AuditController@delete');
    });

    // 结算凭证管理
    Route::namespace('Relevance')->group(function() {

      // 结算凭证管理
      Route::prefix('certificate')->group(function() {
        Route::post('/handle', 'CertificateController@handle');
        Route::post('/delete/{id?}', 'CertificateController@delete');
      });

      // 结算详情管理
      Route::prefix('detail')->group(function() {
        Route::post('/change', 'DetailController@change');
      });
    });
  });


  // 统计管理
  Route::namespace('Statistical')->prefix('statistical')->group(function() {

    // 出车利润率分析
    Route::prefix('profit')->group(function() {
      Route::post('/data','ProfitController@data');
    });

    // 出车单数分析
    Route::prefix('singular')->group(function() {
      Route::post('/data','SingularController@data');
    });

    // 出车利润分析
    Route::prefix('wage')->group(function() {
      Route::post('/data','WageController@data');
    });

    // 出车利润分析
    Route::prefix('expend')->group(function() {
      Route::post('/data','ExpendController@data');
    });

    // 出车率分析
    Route::prefix('rate')->group(function() {
      Route::post('/data','RateController@data');
      Route::post('/info','RateController@info');
    });
  });

});

