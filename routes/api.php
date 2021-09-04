<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
  'namespace'  =>  'Api',
  'middleware'  =>  'serializer:array'
], function ($api)
{
  $api->group([
    'middleware'  =>  'api.throttle', // 启用节流限制
    'limit'  =>  1000, // 允许次数
    'expires'  =>  1, // 分钟
  ], function ($api)
  {
    $api->group(['namespace' => 'System'], function ($api) {
      $api->post('login', 'LoginController@login'); // 密码登录
      $api->post('oauth_login', 'LoginController@oauth_login'); // 一键登录
      $api->post('sms_login', 'LoginController@sms_login'); // 短信登录
      $api->post('sms_code', 'LoginController@sms_code'); // 登录验证码
      $api->post('weixin_login', 'LoginController@weixin_login'); // 微信登录
      $api->post('apple_login', 'LoginController@apple_login'); // 苹果登录
      $api->post('register', 'LoginController@register');
      $api->post('bind_mobile', 'LoginController@bind_mobile');
      $api->post('bind_code', 'LoginController@bind_code');
      $api->post('reset_code', 'LoginController@reset_code');
      $api->post('back_mobile', 'LoginController@back_mobile');
      $api->get('logout', 'LoginController@logout'); // 退出

      // 系统基础数据路由
      $api->group(['prefix' => 'system'], function ($api) {
        $api->get('kernel', 'SystemController@kernel'); // 系统信息路由
      });

      // 上传路由
      $api->group(['prefix' => 'file', 'middleware' => ['auth:api', 'refresh.token', 'failure']], function ($api) {
        // 上传文件
        $api->post('file', 'FileController@file');
        // 上传图片
        $api->post('picture', 'FileController@picture');
      });
    });



    $api->group(['namespace' => 'Module'], function ($api) {

      // 公共路由
      $api->group(['namespace' => 'Common', 'prefix' => 'common'], function ($api) {

        // 省市县路由
        $api->group(['prefix' => 'area'], function ($api) {
          $api->get('list', 'AreaController@list');
        });

        // 系统协议路由
        $api->group(['prefix' => 'agreement'], function ($api) {
          $api->get('about', 'AgreementController@about');
          $api->get('user', 'AgreementController@user');
          $api->get('employ', 'AgreementController@employ');
          $api->get('privacy', 'AgreementController@privacy');
          $api->get('specification', 'AgreementController@specification');
          $api->get('liability', 'AgreementController@liability');
        });

        // 支付回调路由
        $api->group(['prefix' => 'notify'], function ($api) {
          $api->any('wechat', 'NotifyController@wechat');
          $api->any('alipay', 'NotifyController@alipay');
          $api->any('apple', 'NotifyController@apple');
        });

        // 分享路由
        $api->group(['prefix' => 'share'], function ($api) {
          $api->post('data', 'ShareController@data');
        });

        // 客服路由
        $api->group(['prefix' => 'service'], function ($api) {
          $api->post('data', 'ServiceController@data');
        });

        // 支付类型路由
        $api->group(['prefix' => 'pay'], function ($api) {
          $api->post('data', 'PayController@data');
        });
      });



      // 广告路由
      $api->group(['prefix' => 'advertising'], function ($api) {
        $api->get('select', 'AdvertisingController@select');

        $api->group(['namespace' => 'Advertising', 'prefix' => 'position'], function ($api) {
          $api->get('list', 'PositionController@list');
          $api->get('select', 'PositionController@select');
          $api->get('view/{id}', 'PositionController@view');
        });
      });


      // 投诉路由
      $api->group(['namespace' => 'Complain', 'prefix' => 'complain'], function ($api) {
        $api->group(['prefix' => 'category'], function ($api) {
          // 投诉分类路由
          $api->get('select', 'CategoryController@select');
        });
      });


      // 常见问题路由
      $api->group(['prefix'  => 'problem'], function ($api) {
        $api->get('list', 'ProblemController@list');
        $api->get('select', 'ProblemController@select');
        $api->get('view/{id}', 'ProblemController@view');

        // 常见问题分类路由
        $api->group(['namespace' => 'Problem', 'prefix'  => 'category'], function ($api) {
          $api->get('select', 'CategoryController@select');
        });
      });


      // 项目路由
      $api->group(['prefix'  => 'project'], function ($api) {
        // 项目分类路由
        $api->group(['namespace' => 'Project', 'prefix'  => 'category'], function ($api) {
          $api->get('select', 'CategoryController@select');
        });
      });



      // 快讯路由
      $api->group(['prefix'  => 'flash'], function ($api) {
        $api->get('list', 'FlashController@list');
        $api->get('recommend', 'FlashController@recommend');
        $api->get('view/{id}', 'FlashController@view');

        // 快讯关联路由
        $api->group(['namespace' => 'Flash'], function ($api) {

          // 快讯分类路由
          $api->group(['prefix'  => 'category'], function ($api) {
            $api->get('select', 'CategoryController@select');
          });

          // 快讯评论路由
          $api->group(['prefix'  => 'comment'], function ($api) {
            $api->get('list', 'CommentController@list');
            $api->get('other', 'CommentController@other');
          });
        });
      });


      // 资讯路由
      $api->group(['prefix'  => 'information'], function ($api) {
        $api->get('list', 'InformationController@list');
        $api->get('recommend', 'InformationController@recommend');
        $api->get('subject', 'InformationController@subject');
        $api->get('related', 'InformationController@related');
        $api->get('similar', 'InformationController@similar');
        $api->get('view/{id}', 'InformationController@view');

        // 资讯关联路由
        $api->group(['namespace' => 'Information'], function ($api) {

          // 资讯分类路由
          $api->group(['prefix'  => 'category'], function ($api) {
            $api->get('select', 'CategoryController@select');
          });

          // 资讯专题路由
          $api->group(['prefix'  => 'subject'], function ($api) {
            $api->get('select', 'SubjectController@select');
          });

          // 资讯评论路由
          $api->group(['prefix'  => 'comment'], function ($api) {
            $api->get('list', 'CommentController@list');
            $api->get('other', 'CommentController@other');
          });
        });
      });


      // 社区路由
      $api->group(['prefix'  => 'community'], function ($api) {
        $api->get('list', 'CommunityController@list');
        $api->get('hot', 'CommunityController@hot');
        $api->get('recommend', 'CommunityController@recommend');
        $api->get('view/{id}', 'CommunityController@view');

        // 社区关联路由
        $api->group(['namespace' => 'Community'], function ($api) {

          // 社区分类路由
          $api->group(['prefix'  => 'category'], function ($api) {
            $api->get('select', 'CategoryController@select');
          });

          // 社区评论路由
          $api->group(['prefix'  => 'comment'], function ($api) {
            $api->get('list', 'CommentController@list');
            $api->get('other', 'CommentController@other');
          });
        });
      });


      // 通知路由
      $api->group(['namespace' => 'Notice', 'prefix' => 'notice', 'middleware' => ['auth:api', 'refresh.token', 'failure']], function ($api) {

        // 通知分类路由
        $api->group(['prefix'  => 'category'], function ($api) {
          $api->get('select', 'CategoryController@select');
        });
      });


      // 货币路由
      $api->group(['prefix' => 'currency'], function ($api) {

        $api->group(['namespace' => 'Currency'], function ($api) {
          // 货币种类
          $api->group(['prefix' => 'category'], function ($api) {
            $api->get('list', 'CategoryController@list');
            $api->get('select', 'CategoryController@select');
            $api->get('hot', 'CategoryController@hot');
            $api->get('main', 'CategoryController@main');
            $api->get('defi', 'CategoryController@defi');
            $api->get('view/{id}', 'CategoryController@view');
          });

          // 货币符号
          $api->group(['prefix' => 'symbol'], function ($api) {
            $api->get('list', 'SymbolController@list');
            $api->get('quote', 'SymbolController@quote');
            $api->get('view/{id}', 'SymbolController@view');
          });
        });
      });


      // 贵宾路由
      $api->group(['prefix'  => 'vip'], function ($api) {
        $api->get('list', 'VipController@list');
        $api->get('select', 'VipController@select');
        $api->get('view/{id}', 'VipController@view');
      });



      // 会员路由
      $api->group(['prefix'  => 'member', 'middleware' => ['auth:api', 'refresh.token', 'failure']], function ($api) {
        $api->get('archive', 'MemberController@archive');
        $api->get('asset', 'MemberController@asset');
        $api->get('status', 'MemberController@status');
        $api->post('handle', 'MemberController@handle');
        $api->get('data', 'MemberController@data');
        $api->post('password', 'MemberController@password');
        $api->post('change_code', 'MemberController@change_code');
        $api->post('change_mobile', 'MemberController@change_mobile');


        // 会员关联内容路由
        $api->group(['namespace' => 'Member'], function ($api) {

          // 会员认证路由
          $api->group(['prefix'  => 'certification'], function ($api) {
            $api->post('status', 'CertificationController@status');
            $api->post('personal', 'CertificationController@personal');
            $api->post('company', 'CertificationController@company');
            $api->post('project', 'CertificationController@project');
            $api->get('data', 'CertificationController@data');
          });

          // 会员资产路由
          $api->group(['prefix'  => 'asset'], function ($api) {
            $api->get('data', 'AssetController@data');
          });

          // 会员资产明细路由
          $api->group(['prefix'  => 'money'], function ($api) {
            $api->get('list', 'MoneyController@list');
            $api->get('income', 'MoneyController@income');
            $api->get('expend', 'MoneyController@expend');
            $api->post('handle', 'MoneyController@handle');
          });

          // 会员消息路由
          $api->group(['prefix'  => 'notice'], function ($api) {
            $api->get('list', 'NoticeController@list');
            $api->post('finish', 'NoticeController@finish');
          });


          // 会员关注路由
          $api->group(['prefix'  => 'attention'], function ($api) {
            $api->get('list', 'AttentionController@list');
            $api->post('status', 'AttentionController@status');
            $api->post('handle', 'AttentionController@handle');
          });

          // 会员邀请路由
          $api->group(['prefix'  => 'invitation'], function ($api) {
            $api->get('list', 'InvitationController@list');
            $api->post('data', 'InvitationController@data');
            $api->post('status', 'InvitationController@status');
            $api->post('handle', 'InvitationController@handle');
          });






          // 会员投诉路由
          $api->group(['prefix'  => 'complain'], function ($api) {
            $api->get('list', 'ComplainController@list');
            $api->get('view/{id}', 'ComplainController@view');
            $api->post('handle', 'ComplainController@handle');
          });


          // 会员客服路由
          $api->group(['prefix'  => 'contact'], function ($api) {
            $api->post('handle', 'ContactController@handle');
          });


          // 会员设置路由
          $api->group(['prefix'  => 'setting'], function ($api) {
            $api->get('data', 'SettingController@data');
            $api->post('handle', 'SettingController@handle');
          });


          // 贵宾路由
          $api->group(['prefix'  => 'vip'], function ($api) {
            $api->post('status', 'VipController@status');
            $api->post('handle', 'VipController@handle');
          });


          // 购物车路由
          $api->group(['prefix'  => 'cart'], function ($api) {
            $api->get('select', 'CartController@select');
            $api->post('add', 'CartController@add');
            $api->post('change', 'CartController@change');
            $api->post('delete', 'CartController@delete');
          });


          // 会员快讯路由
          $api->group(['namespace' => 'Flash', 'prefix'  => 'flash'], function ($api) {

            // 会员快讯利益路由
            $api->group(['prefix'  => 'benefit'], function ($api) {
              $api->post('status', 'BenefitController@status');
              $api->post('bullish', 'BenefitController@bullish');
              $api->post('bearish', 'BenefitController@bearish');
            });

            // 会员快讯评论路由
            $api->group(['prefix'  => 'comment'], function ($api) {
              $api->post('handle', 'CommentController@handle');

              // 会员社区评论点赞路由
              $api->group(['namespace' => 'Comment', 'prefix'  => 'approval'], function ($api) {
                $api->post('status', 'ApprovalController@status');
                $api->post('handle', 'ApprovalController@handle');
              });
            });
          });


          // 会员资讯路由
          $api->group(['prefix'  => 'information'], function ($api) {
            $api->get('list', 'InformationController@list');
            $api->get('view/{id}', 'InformationController@view');
            $api->post('handle', 'InformationController@handle');
            $api->post('delete', 'InformationController@delete');


            // 会员资讯关联路由
            $api->group(['namespace' => 'Information'], function ($api) {

              // 会员资讯浏览路由
              $api->group(['prefix'  => 'browse'], function ($api) {
                $api->get('list', 'BrowseController@list');
                $api->post('clear', 'BrowseController@clear');
              });

              // 会员资讯评论路由
              $api->group(['prefix'  => 'comment'], function ($api) {
                $api->post('handle', 'CommentController@handle');

                // 会员社区评论点赞路由
                $api->group(['namespace' => 'Comment', 'prefix'  => 'approval'], function ($api) {
                  $api->post('status', 'ApprovalController@status');
                  $api->post('handle', 'ApprovalController@handle');
                });
              });

              // 会员资讯点赞路由
              $api->group(['prefix'  => 'approval'], function ($api) {
                $api->get('list', 'ApprovalController@list');
                $api->post('status', 'ApprovalController@status');
                $api->post('handle', 'ApprovalController@handle');
              });

              // 会员资讯收藏路由
              $api->group(['prefix'  => 'collection'], function ($api) {
                $api->get('list', 'CollectionController@list');
                $api->post('status', 'CollectionController@status');
                $api->post('handle', 'CollectionController@handle');
              });
            });
          });


          // 会员社区路由
          $api->group(['prefix'  => 'community'], function ($api) {
            $api->get('list', 'CommunityController@list');
            $api->get('view/{id}', 'CommunityController@view');
            $api->post('handle', 'CommunityController@handle');


            // 会员社区关联路由
            $api->group(['namespace' => 'Community'], function ($api) {

              // 会员社区评论路由
              $api->group(['prefix'  => 'comment'], function ($api) {
                $api->post('handle', 'CommentController@handle');

                // 会员社区评论点赞路由
                $api->group(['namespace' => 'Comment', 'prefix'  => 'approval'], function ($api) {
                  $api->post('status', 'ApprovalController@status');
                  $api->post('handle', 'ApprovalController@handle');
                });
              });

              // 会员社区点赞路由
              $api->group(['prefix'  => 'approval'], function ($api) {
                $api->get('list', 'ApprovalController@list');
                $api->post('status', 'ApprovalController@status');
                $api->post('handle', 'ApprovalController@handle');
              });

              // 会员社区收藏路由
              $api->group(['prefix'  => 'collection'], function ($api) {
                $api->get('list', 'CollectionController@list');
                $api->post('status', 'CollectionController@status');
                $api->post('handle', 'CollectionController@handle');
              });

              // 会员社区关注路由
              $api->group(['prefix'  => 'attention'], function ($api) {
                $api->get('list', 'AttentionController@list');
                $api->post('status', 'AttentionController@status');
                $api->post('handle', 'AttentionController@handle');
              });
            });
          });

          // 会员订单路由
          $api->group(['prefix'  => 'order'], function ($api) {
            $api->get('list', 'OrderController@list');
            $api->get('view/{id}', 'OrderController@view');
            $api->post('handle', 'OrderController@handle');
            $api->post('change', 'OrderController@change');
            $api->post('pay', 'OrderController@pay');
            $api->post('buy', 'OrderController@buy');
            $api->post('finish', 'OrderController@finish');
            $api->post('cancel', 'OrderController@cancel');
          });


          // 会员课程路由
          $api->group(['prefix'  =>  'courseware'], function ($api) {
            $api->get('list', 'CoursewareController@list');
            $api->get('status/{id}', 'CoursewareController@status');
            $api->get('view/{id}', 'CoursewareController@view');
            $api->post('finish', 'CoursewareController@finish');
            $api->post('expense', 'CoursewareController@expense');

            // 会员课程知识点路由
            $api->group(['namespace' => 'Courseware', 'prefix'  =>  'point'], function ($api) {
              $api->get('list', 'PointController@list');
              $api->get('select', 'PointController@select');
              $api->get('view/{id}', 'PointController@view');

              // 会员课程知识点点赞路由
              $api->group(['namespace' => 'Point', 'prefix'  =>  'approval'], function ($api) {
                $api->get('list', 'ApprovalController@list');
                $api->post('status', 'ApprovalController@status');
                $api->post('handle', 'ApprovalController@handle');
              });
            });
          });


          // 会员货币路由
          $api->group(['namespace' => 'Currency', 'prefix'  => 'currency'], function ($api) {

            // 自选货币路由
            $api->group(['prefix'  => 'optional'], function ($api) {
              $api->get('list', 'OptionalController@list');
              $api->post('status', 'OptionalController@status');
              $api->post('handle', 'OptionalController@handle');
            });
          });
        });
      });


      // 教育中心路由
      $api->group(['namespace' => 'Education', 'prefix' => 'education'], function ($api) {

        // 课件路由
        $api->group(['prefix' => 'courseware'], function ($api) {
          $api->any('list', 'CoursewareController@list');
          $api->get('recommend', 'CoursewareController@recommend');
          $api->get('view/{id}', 'CoursewareController@view');

          // 课件级别
          $api->group(['namespace' => 'Courseware'], function ($api) {

            // 课件分类
            $api->group(['prefix' => 'category'], function ($api) {
              $api->get('select', 'CategoryController@select');
            });

            // 课件老师
            $api->group(['prefix' => 'teacher'], function ($api) {
              $api->get('select', 'TeacherController@select');
              $api->get('view/{id}', 'TeacherController@view');
            });

            // 课件知识点
            $api->group(['prefix' => 'point'], function ($api) {
              $api->any('list', 'PointController@list');
              $api->get('select', 'PointController@select');
              $api->get('view/{id}', 'PointController@view');
            });

          });
        });
      });
    });
  });
});
