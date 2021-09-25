<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
  'namespace'  =>  'Platform',
  'middleware'  =>  'serializer:array'
], function ($api)
{
  $api->group([
    'middleware'  =>  'api.throttle', // 启用节流限制
    'limit'  =>  1000, // 允许次数
    'expires'  =>  1, // 分钟
  ], function ($api)
  {
    // --------------------------------------------------
    // 核心路由
    $api->group(['namespace' => 'System'], function ($api) {

      // 登录路由
      $api->post('login', 'LoginController@login');
      $api->post('register', 'LoginController@register');
      $api->get('logout', 'LoginController@logout');
      $api->get('check_user_login', 'LoginController@check_user_login'); // 验证是否登录

      $api->post('kernel', 'SystemController@kernel');
      $api->post('clear', 'SystemController@clear');

      // 首页路由
      $api->group(['prefix' => 'index'], function ($api) {
        $api->get('order', 'IndexController@order');
        $api->get('todo', 'IndexController@todo');
        $api->get('course', 'IndexController@course');
        $api->get('member', 'IndexController@member');
        $api->get('data', 'IndexController@data');
      });

      // 文件上传路由
      $api->group(['prefix' => 'file'], function ($api) {
        $api->post('file', 'FileController@file');
        $api->post('picture', 'FileController@picture');
        $api->post('attachment', 'FileController@attachment');
        $api->post('editor_file', 'FileController@editor_file');
        $api->post('editor_picture', 'FileController@editor_picture');
      });


      // 平台用户路由
      $api->group(['prefix'  =>  'user'], function ($api) {
        $api->any('list', 'UserController@list');
        $api->get('select', 'UserController@select');
        $api->get('view/{id}', 'UserController@view');
        $api->get('action', 'UserController@action');
        $api->post('handle', 'UserController@handle');
        $api->post('delete', 'UserController@delete');
        $api->get('tree', 'UserController@tree');
        $api->any('password', 'UserController@password');
        $api->any('change_password', 'UserController@change_password');

        // 平台用户消息路由
        $api->group(['namespace' => 'User', 'prefix'  =>  'message'], function ($api) {
          $api->any('list', 'MessageController@list');
          $api->post('unread', 'MessageController@unread');
          $api->post('readed', 'MessageController@readed');
          $api->post('delete', 'MessageController@delete');
        });
      });


      // 平台角色路由
      $api->group(['prefix'  =>  'role'], function ($api) {
        $api->any('list', 'RoleController@list');
        $api->get('select', 'RoleController@select');
        $api->get('view/{id}', 'RoleController@view');
        $api->post('handle', 'RoleController@handle');
        $api->post('delete', 'RoleController@delete');
        $api->any('permission/{id}', 'RoleController@permission');
      });


      // 平台菜单路由
      $api->group(['prefix'  =>  'menu'], function ($api) {
        $api->any('list', 'MenuController@list');
        $api->get('select', 'MenuController@select');
        $api->get('view/{id}', 'MenuController@view');
        $api->post('handle', 'MenuController@handle');
        $api->post('delete', 'MenuController@delete');

        $api->any('level', 'MenuController@level');
        $api->post('active', 'MenuController@active');
        $api->post('track', 'MenuController@track');
      });


       // 系统配置路由
      $api->group(['prefix'  =>  'config'], function ($api) {
        // 配置管理路由
        $api->any('list', 'ConfigController@list');
        $api->get('select', 'ConfigController@select');
        $api->get('view/{id}', 'ConfigController@view');
        $api->post('handle', 'ConfigController@handle');
        $api->post('delete/{id?}', 'ConfigController@delete');

        // 配置分类管理路由
        $api->group(['namespace' => 'Config', 'prefix'  =>  'category'], function ($api) {
          $api->any('list', 'CategoryController@list');
          $api->get('select', 'CategoryController@select');
          $api->get('view/{id}', 'CategoryController@view');
          $api->get('level', 'CategoryController@level');
          $api->post('handle', 'CategoryController@handle');
          $api->post('delete/{id?}', 'CategoryController@delete');
        });
      });


      // 系统设置路由
      $api->group(['prefix'  =>  'setting'], function ($api) {
        $api->any('data', 'SettingController@data');
        $api->any('about', 'SettingController@about');
        $api->any('user', 'SettingController@user');
        $api->any('employ', 'SettingController@employ');
        $api->any('privacy', 'SettingController@privacy');
        $api->any('specification', 'SettingController@specification');
        $api->any('liability', 'SettingController@liability');
      });


      // 系统消息路由
      $api->group(['prefix'  =>  'message'], function ($api) {
        $api->any('list', 'MessageController@list');
        $api->get('view/{id}', 'MessageController@view');
        $api->post('handle', 'MessageController@handle');
        $api->get('type', 'MessageController@type');
        $api->post('readed', 'MessageController@readed');
        $api->post('delete', 'MessageController@delete');
      });

      // 系统日志路由
      $api->group(['namespace' => 'Log', 'prefix'  =>  'log'], function ($api) {
        $api->group(['prefix'  =>  'action'], function ($api) {
          $api->any('list', 'ActionController@list');
          $api->get('view/{id}', 'ActionController@view');
          $api->post('delete', 'ActionController@delete');
        });
      });
    });


    // --------------------------------------------------
    // 模块路由
    $api->group(['namespace' => 'Module'], function ($api) {

      // 公共路由
      $api->group(['namespace' => 'Common', 'prefix'  =>  'common'], function ($api) {
        $api->get('area/list', 'AreaController@list'); // 地区路由
        $api->get('single/audit', 'SingleController@audit'); // 审核状态路由
      });

      // 会员路由
      $api->group(['prefix'  => 'member'], function ($api) {
        $api->any('list', 'MemberController@list');
        $api->get('select', 'MemberController@select');
        $api->get('view/{id}', 'MemberController@view');
        $api->post('handle', 'MemberController@handle');
        $api->post('status', 'MemberController@status');
        $api->post('delete', 'MemberController@delete');

        $api->group(['namespace'  =>  'Member'], function ($api) {

          // 会员角色路由
          $api->group(['prefix'  =>  'role'], function ($api) {
            $api->any('list', 'RoleController@list');
            $api->get('select', 'RoleController@select');
            $api->get('view/{id}', 'RoleController@view');
            $api->post('handle', 'RoleController@handle');
            $api->post('delete', 'RoleController@delete');
            $api->any('permission/{id}', 'RoleController@permission');
          });


          // 会员认证路由
          $api->group(['prefix'  =>  'certification'], function ($api) {
            $api->get('data', 'CertificationController@data');
            $api->post('handle', 'CertificationController@handle');
          });


          // 会员课程路由
          $api->group(['prefix'  =>  'course'], function ($api) {
            $api->get('list', 'CourseController@list');
          });

          // 会员订单路由
          $api->group(['namespace'  =>  'Order', 'prefix'  =>  'order'], function ($api) {

            // 会员课程订单路由
            $api->group(['prefix'  =>  'course'], function ($api) {
              $api->get('select', 'CourseController@select');
            });
          });
        });
      });

      // 店长路由
      $api->group(['prefix'  => 'manager'], function ($api) {
        $api->any('list', 'ManagerController@list');
        $api->get('select', 'ManagerController@select');
        $api->get('view/{id}', 'ManagerController@view');
        $api->post('handle', 'ManagerController@handle');
        $api->post('status', 'ManagerController@status');
        $api->post('delete', 'ManagerController@delete');
      });

      // 代理人路由
      $api->group(['prefix'  => 'agent'], function ($api) {
        $api->any('list', 'AgentController@list');
        $api->get('select', 'AgentController@select');
        $api->get('view/{id}', 'AgentController@view');
        $api->post('handle', 'AgentController@handle');
        $api->any('facility', 'AgentController@facility');
        $api->post('status', 'AgentController@status');
        $api->post('delete', 'AgentController@delete');
      });

      // 贵宾路由
      $api->group(['prefix'  =>  'vip'], function ($api) {
        $api->any('list', 'VipController@list');
        $api->get('select', 'VipController@select');
        $api->get('view/{id}', 'VipController@view');
        $api->post('handle', 'VipController@handle');
        $api->post('delete', 'VipController@delete');
      });


      // 广告路由
      $api->group(['prefix' => 'advertising'], function ($api) {
        // 广告路由
        $api->any('list', 'AdvertisingController@list');
        $api->get('select', 'AdvertisingController@select');
        $api->get('view/{id}', 'AdvertisingController@view');
        $api->post('handle', 'AdvertisingController@handle');
        $api->post('status', 'AdvertisingController@status');
        $api->post('delete', 'AdvertisingController@delete');

        // 广告位路由
        $api->group(['namespace' => 'Advertising', 'prefix' => 'position'], function ($api) {
          $api->any('list', 'PositionController@list');
          $api->get('select', 'PositionController@select');
          $api->get('view/{id}', 'PositionController@view');
          $api->post('handle', 'PositionController@handle');
          $api->post('delete/{id?}', 'PositionController@delete');
        });
      });


      // 常见问题路由
      $api->group(['prefix' => 'problem'], function ($api) {
        $api->any('list', 'ProblemController@list');
        $api->get('select', 'ProblemController@select');
        $api->get('view/{id}', 'ProblemController@view');
        $api->post('handle', 'ProblemController@handle');
        $api->post('delete', 'ProblemController@delete');

        // 常见问题分类路由
        $api->group(['namespace' => 'Problem', 'prefix' => 'category'], function ($api) {
          $api->any('list', 'CategoryController@list');
          $api->get('select', 'CategoryController@select');
          $api->get('view/{id}', 'CategoryController@view');
          $api->post('handle', 'CategoryController@handle');
          $api->post('delete/{id?}', 'CategoryController@delete');
        });
      });


      // 投诉路由
      $api->group(['prefix' => 'complain'], function ($api) {
        // 投诉路由
        $api->any('list', 'ComplainController@list');
        $api->post('read', 'ComplainController@read');
        $api->post('delete', 'ComplainController@delete');

        // 投诉分类路由
        $api->group(['namespace' => 'Complain', 'prefix' => 'category'], function ($api) {
          $api->any('list', 'CategoryController@list');
          $api->get('select', 'CategoryController@select');
          $api->get('view/{id}', 'CategoryController@view');
          $api->post('status', 'CategoryController@status');
          $api->post('handle', 'CategoryController@handle');
          $api->post('delete/{id?}', 'CategoryController@delete');
        });
      });


      // 通知路由
      $api->group(['prefix' => 'notice'], function ($api) {
        $api->any('list', 'NoticeController@list');
        $api->get('select', 'NoticeController@select');
        $api->get('view/{id}', 'NoticeController@view');
        $api->post('handle', 'NoticeController@handle');
        $api->post('delete', 'NoticeController@delete');

        // 通知分类路由
        $api->group(['namespace' => 'Notice', 'prefix' => 'category'], function ($api) {
          $api->any('list', 'CategoryController@list');
          $api->get('select', 'CategoryController@select');
          $api->get('view/{id}', 'CategoryController@view');
          $api->post('handle', 'CategoryController@handle');
          $api->post('delete/{id?}', 'CategoryController@delete');
        });
      });


      // 联系客服路由
      $api->group(['prefix' => 'contact'], function ($api) {
        $api->any('list', 'ContactController@list');
        $api->post('delete', 'ContactController@delete');
      });


      // 打印机路由
      $api->group(['prefix' => 'printer'], function ($api) {
        $api->any('list', 'PrinterController@list');
        $api->get('select', 'PrinterController@select');
        $api->get('data', 'PrinterController@data');
        $api->get('view/{id}', 'PrinterController@view');
        $api->post('handle', 'PrinterController@handle');
        $api->post('status', 'PrinterController@status');
        $api->post('delete', 'PrinterController@delete');

        // 打印机日志路由
        $api->group(['namespace' => 'Printer', 'prefix' => 'log'], function ($api) {
          $api->any('list', 'LogController@list');
          $api->get('view/{id}', 'LogController@view');
          $api->post('delete/{id?}', 'LogController@delete');
        });
      });

      // 耗材路由
      $api->group(['prefix' => 'material'], function ($api) {
        // 耗材路由
        $api->any('list', 'MaterialController@list');
        $api->get('select', 'MaterialController@select');
        $api->get('view/{id}', 'MaterialController@view');
        $api->post('handle', 'MaterialController@handle');
        $api->post('delete', 'MaterialController@delete');

        // 耗材分类路由
        $api->group(['namespace' => 'Material', 'prefix' => 'category'], function ($api) {
          $api->any('list', 'CategoryController@list');
          $api->get('select', 'CategoryController@select');
          $api->get('view/{id}', 'CategoryController@view');
          $api->post('handle', 'CategoryController@handle');
          $api->post('delete/{id?}', 'CategoryController@delete');
        });
      });

      // 报修路由
      $api->group(['prefix' => 'repair'], function ($api) {
        // 报修路由
        $api->any('list', 'RepairController@list');
        $api->get('select', 'RepairController@select');
        $api->get('view/{id}', 'RepairController@view');
        $api->post('handle', 'RepairController@handle');
        $api->post('delete', 'RepairController@delete');

        // 报修分类路由
        $api->group(['namespace' => 'Repair', 'prefix' => 'category'], function ($api) {
          $api->any('list', 'CategoryController@list');
          $api->get('select', 'CategoryController@select');
          $api->get('view/{id}', 'CategoryController@view');
          $api->post('handle', 'CategoryController@handle');
          $api->post('delete/{id?}', 'CategoryController@delete');
        });
      });



      // 订单路由
      $api->group(['prefix' => 'order'], function ($api) {
        $api->any('list', 'OrderController@list');
        $api->get('select', 'OrderController@select');
        $api->get('view/{id}', 'OrderController@view');
        $api->post('cancel', 'OrderController@cancel');
        $api->post('handle', 'OrderController@handle');
        $api->post('delete', 'OrderController@delete');
        $api->post('export', 'OrderController@export');
      });


      // 提现路由
      $api->group(['prefix' => 'withdrawal'], function ($api) {
        $api->any('list', 'WithdrawalController@list');
        $api->post('handle', 'WithdrawalController@handle');
      });

      // 价格路由
      $api->group(['prefix' => 'price'], function ($api) {
        $api->any('list', 'PriceController@list');
        $api->get('select', 'PriceController@select');
        $api->get('view/{id}', 'PriceController@view');
        $api->post('handle', 'PriceController@handle');
        $api->post('delete', 'PriceController@delete');
      });
    });
  });
});
