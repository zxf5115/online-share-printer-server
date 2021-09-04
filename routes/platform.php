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


      // 项目路由
      $api->group(['prefix' => 'project'], function ($api) {
        // 项目分类路由
        $api->group(['namespace' => 'Project', 'prefix' => 'category'], function ($api) {
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


      // 快讯路由
      $api->group(['prefix' => 'flash'], function ($api) {
        $api->any('list', 'FlashController@list');
        $api->get('select', 'FlashController@select');
        $api->get('view/{id}', 'FlashController@view');
        $api->post('status', 'FlashController@status');
        $api->post('handle', 'FlashController@handle');
        $api->post('delete/{id?}', 'FlashController@delete');

        // 快讯分类路由
        $api->group(['namespace' => 'Flash', 'prefix' => 'category'], function ($api) {
          $api->any('list', 'CategoryController@list');
          $api->get('select', 'CategoryController@select');
          $api->get('view/{id}', 'CategoryController@view');
          $api->post('status', 'CategoryController@status');
          $api->post('handle', 'CategoryController@handle');
          $api->post('delete/{id?}', 'CategoryController@delete');
        });
      });


      // 资讯路由
      $api->group(['prefix' => 'information'], function ($api) {
        $api->any('list', 'InformationController@list');
        $api->get('select', 'InformationController@select');
        $api->get('view/{id}', 'InformationController@view');
        $api->post('status', 'InformationController@status');
        $api->post('handle', 'InformationController@handle');
        $api->post('delete/{id?}', 'InformationController@delete');

        $api->group(['namespace' => 'Information'], function ($api) {
          // 资讯分类路由
          $api->group(['prefix' => 'category'], function ($api) {
            $api->any('list', 'CategoryController@list');
            $api->get('select', 'CategoryController@select');
            $api->get('view/{id}', 'CategoryController@view');
            $api->post('status', 'CategoryController@status');
            $api->post('handle', 'CategoryController@handle');
            $api->post('delete/{id?}', 'CategoryController@delete');
          });

          // 资讯专题路由
          $api->group(['prefix' => 'subject'], function ($api) {
            $api->any('list', 'SubjectController@list');
            $api->get('select', 'SubjectController@select');
            $api->get('view/{id}', 'SubjectController@view');
            $api->post('status', 'SubjectController@status');
            $api->post('handle', 'SubjectController@handle');
            $api->post('delete/{id?}', 'SubjectController@delete');
          });

          // 标签路由
          $api->group(['prefix' => 'label'], function ($api) {
            $api->any('list', 'LabelController@list');
            $api->get('select', 'LabelController@select');
            $api->get('view/{id}', 'LabelController@view');
            $api->post('handle', 'LabelController@handle');
            $api->post('delete/{id?}', 'LabelController@delete');
          });

          // 敏感词路由
          $api->group(['prefix' => 'sensitive'], function ($api) {
            $api->any('list', 'SensitiveController@list');
            $api->get('select', 'SensitiveController@select');
            $api->get('view/{id}', 'SensitiveController@view');
            $api->post('handle', 'SensitiveController@handle');
            $api->post('delete/{id?}', 'SensitiveController@delete');
          });

          // 评论路由
          $api->group(['prefix' => 'comment'], function ($api) {
            $api->any('list', 'CommentController@list');
            $api->post('delete/{id?}', 'CommentController@delete');
          });
        });
      });


      // 社区路由
      $api->group(['prefix' => 'community'], function ($api) {
        $api->any('list', 'CommunityController@list');
        $api->get('select', 'CommunityController@select');
        $api->get('view/{id}', 'CommunityController@view');
        $api->post('status', 'CommunityController@status');
        $api->post('handle', 'CommunityController@handle');
        $api->post('delete/{id?}', 'CommunityController@delete');

        // 社区分类路由
        $api->group(['namespace' => 'Community', 'prefix' => 'category'], function ($api) {
          $api->any('list', 'CategoryController@list');
          $api->get('select', 'CategoryController@select');
          $api->get('view/{id}', 'CategoryController@view');
          $api->post('status', 'CategoryController@status');
          $api->post('handle', 'CategoryController@handle');
          $api->post('delete/{id?}', 'CategoryController@delete');
        });
      });



      // 联系客服路由
      $api->group(['prefix' => 'contact'], function ($api) {
        $api->any('list', 'ContactController@list');
        $api->post('delete', 'ContactController@delete');
      });


      // 教育中心路由
      $api->group(['namespace' => 'Education', 'prefix' => 'education'], function ($api) {

        // 课件路由
        $api->group(['prefix' => 'courseware'], function ($api) {
          $api->any('list', 'CoursewareController@list');
          $api->get('select', 'CoursewareController@select');
          $api->get('view/{id}', 'CoursewareController@view');
          $api->post('handle', 'CoursewareController@handle');
          $api->post('status', 'CoursewareController@status');
          $api->post('delete/{id?}', 'CoursewareController@delete');

          $api->group(['namespace' => 'Courseware'], function ($api) {
            // 课件分类路由
            $api->group(['prefix'  => 'category'], function ($api) {
              $api->any('list', 'CategoryController@list');
              $api->get('select', 'CategoryController@select');
              $api->get('view/{id}', 'CategoryController@view');
              $api->post('handle', 'CategoryController@handle');
              $api->post('status', 'CategoryController@status');
              $api->post('delete/{id?}', 'CategoryController@delete');
            });

            // 课件老师路由
            $api->group(['prefix'  => 'teacher'], function ($api) {
              $api->any('list', 'TeacherController@list');
              $api->get('select', 'TeacherController@select');
              $api->get('view/{id}', 'TeacherController@view');
              $api->post('handle', 'TeacherController@handle');
              $api->post('status', 'TeacherController@status');
              $api->post('delete/{id?}', 'TeacherController@delete');
            });

            // 课件知识点路由
            $api->group(['prefix'  => 'point'], function ($api) {
              $api->any('list', 'PointController@list');
              $api->get('select', 'PointController@select');
              $api->get('view/{id}', 'PointController@view');
              $api->post('handle', 'PointController@handle');
              $api->post('delete/{id?}', 'PointController@delete');
            });
          });
        });
      });





      // 货币路由
      $api->group(['prefix' => 'currency'], function ($api) {

        $api->group(['namespace' => 'Currency'], function ($api) {
          // 货币种类
          $api->group(['prefix' => 'category'], function ($api) {
            $api->get('list', 'CategoryController@list');
            $api->get('select', 'CategoryController@select');
            $api->get('view/{id}', 'CategoryController@view');
            $api->post('status', 'CategoryController@status');
            $api->post('handle', 'CategoryController@handle');
            $api->post('delete/{id?}', 'CategoryController@delete');
          });

          // 货币交易
          $api->group(['prefix' => 'symbol'], function ($api) {
            $api->get('list', 'SymbolController@list');
            $api->get('select', 'SymbolController@select');
            $api->get('view/{id}', 'SymbolController@view');
            $api->post('handle', 'SymbolController@handle');
            $api->post('delete/{id?}', 'SymbolController@delete');
          });
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
    });
  });
});
