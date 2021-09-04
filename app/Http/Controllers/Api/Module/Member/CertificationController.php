<?php
namespace App\Http\Controllers\Api\Module\Member;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Constant\Code;
use App\Http\Controllers\Api\BaseController;


/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2021-06-17
 *
 * 会员认证控制器类
 */
class CertificationController extends BaseController
{
  // 模型名称
  protected $_model = 'App\Models\Api\Module\Member\Certification';

  // 关联对象
  protected $_relevance = [];


  /**
   * @api {post} /api/member/certification/status 01. 会员是否认证
   * @apiDescription 当前会员是否认证
   * @apiGroup 29. 会员认证模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiSuccess (字段说明) {Boolean} status 是否认证
   *
   * @apiSampleRequest /api/member/certification/status
   * @apiVersion 1.0.0
   */
  public function status(Request $request)
  {
    try
    {
      $status = true;

      $condition = self::getCurrentWhereData();

      $response = $this->_model::getRow($condition);

      if(empty($response->id))
      {
        $status = false;
      }

      return self::success($status);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return self::error(Code::ERROR);
    }
  }


  /**
   * @api {post} /api/member/certification/personal 02. 个人认证
   * @apiDescription 当前会员个人认证
   * @apiGroup 29. 会员认证模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} id_card_front_picture 身份证正面照片
   * @apiParam {string} id_card_behind_picture 身份证反面照片
   *
   * @apiSampleRequest /api/member/certification/personal
   * @apiVersion 1.0.0
   */
  public function personal(Request $request)
  {
    $messages = [
      'id_card_front_picture.required'  => '请您上传身份证正面照片',
      'id_card_behind_picture.required' => '请您上传身份证反面照片',
    ];

    $rule = [
      'id_card_front_picture'  => 'required',
      'id_card_behind_picture' => 'required'
    ];

    // 验证用户数据内容是否正确
    $validation = self::validation($request, $messages, $rule);

    if(!$validation['status'])
    {
      return $validation['message'];
    }
    else
    {
      DB::beginTransaction();

      try
      {
        $member_id = self::getCurrentId();

        $model = $this->_model::firstOrNew(['member_id' => $member_id]);

        $model->organization_id = self::getOrganizationId();
        $model->member_id       = $member_id;
        $model->type            = 1;
        $model->save();

        $data = [
          'id_card_front_picture'  => $request->id_card_front_picture,
          'id_card_behind_picture' => $request->id_card_behind_picture
        ];

        if(!empty($data))
        {
          $model->personal()->delete();
          $model->personal()->create($data);
        }

        DB::commit();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        DB::rollback();

        // 记录异常信息
        self::record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }


  /**
   * @api {post} /api/member/certification/company 03. 企业认证
   * @apiDescription 当前会员企业认证
   * @apiGroup 29. 会员认证模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} company_name 企业名称
   * @apiParam {string} business_license_no 营业执照号
   * @apiParam {string} business_license_picture 营业执照图片
   *
   * @apiSampleRequest /api/member/certification/company
   * @apiVersion 1.0.0
   */
  public function company(Request $request)
  {
    $messages = [
      'company_name.required'             => '请您输入企业名称',
      'business_license_no.required'      => '请您输入营业执照号',
      'business_license_picture.required' => '请您上传营业执照图片',
    ];

    $rule = [
      'company_name'             => 'required',
      'business_license_no'      => 'required',
      'business_license_picture' => 'required'
    ];

    // 验证用户数据内容是否正确
    $validation = self::validation($request, $messages, $rule);

    if(!$validation['status'])
    {
      return $validation['message'];
    }
    else
    {
      DB::beginTransaction();

      try
      {
        $member_id = self::getCurrentId();

        $model = $this->_model::firstOrNew(['member_id' => $member_id]);

        $model->organization_id = self::getOrganizationId();
        $model->member_id       = $member_id;
        $model->type            = 2;
        $model->save();

        $data = [
          'company_name'             => $request->company_name,
          'business_license_no'      => $request->business_license_no,
          'business_license_picture' => $request->business_license_picture,
        ];

        if(!empty($data))
        {
          $model->company()->delete();
          $model->company()->create($data);
        }

        DB::commit();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        DB::rollback();

        // 记录异常信息
        self::record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }


  /**
   * @api {post} /api/member/certification/project 04. 项目认证
   * @apiDescription 当前会员项目认证
   * @apiGroup 29. 会员认证模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiParam {string} project_name 项目名称
   * @apiParam {string} project_logo 项目logo
   * @apiParam {string} realname 联系人
   * @apiParam {string} mobile 联系人手机号
   * @apiParam {string} category_id 项目类型
   * @apiParam {string} [project_website] 项目官网
   * @apiParam {string} [project_document] 白皮书地址
   * @apiParam {string} [project_social] 社交媒体
   * @apiParam {string} [project_report] 审计报告
   * @apiParam {string} [project_github] github地址
   *
   * @apiSampleRequest /api/member/certification/project
   * @apiVersion 1.0.0
   */
  public function project(Request $request)
  {
    $messages = [
      'project_name.required' => '请您输入项目名称',
      'project_logo.required' => '请您上传项目Logo',
      'realname.required'     => '请您输入联系人姓名',
      'mobile.required'       => '请您输入联系人电话',
      'category_id.required'  => '请您选择项目类别',
    ];

    $rule = [
      'project_name' => 'required',
      'project_logo' => 'required',
      'realname'     => 'required',
      'mobile'       => 'required',
      'category_id'  => 'required'
    ];

    // 验证用户数据内容是否正确
    $validation = self::validation($request, $messages, $rule);

    if(!$validation['status'])
    {
      return $validation['message'];
    }
    else
    {
      DB::beginTransaction();

      try
      {
        $member_id = self::getCurrentId();

        $model = $this->_model::firstOrNew(['member_id' => $member_id]);

        $model->organization_id = self::getOrganizationId();
        $model->member_id       = $member_id;
        $model->type            = 3;
        $model->save();

        $data = [
          'project_name'     => $request->project_name,
          'project_logo'     => $request->project_logo,
          'realname'         => $request->realname,
          'mobile'           => $request->mobile,
          'category_id'      => $request->category_id,
          'project_website'  => $request->project_website ?? '',
          'project_document' => $request->project_document ?? '',
          'project_social'   => $request->project_social ?? '',
          'project_report'   => $request->project_report ?? '',
          'project_github'   => $request->project_github ?? '',
        ];

        if(!empty($data))
        {
          $model->project()->delete();
          $model->project()->create($data);
        }

        DB::commit();

        return self::success(Code::message(Code::HANDLE_SUCCESS));
      }
      catch(\Exception $e)
      {
        DB::rollback();

        // 记录异常信息
        self::record($e);

        return self::error(Code::HANDLE_FAILURE);
      }
    }
  }


  /**
   * @api {post} /api/member/certification/data 05. 我的认证
   * @apiDescription 当前会员认证信息
   * @apiGroup 29. 会员认证模块
   * @apiPermission jwt
   * @apiHeader {String} Authorization 身份令牌
   * @apiHeaderExample {json} Header-Example:
   * {
   *   "Authorization": "Bearer eyJhbGciOiJIUzUxMiJ9.eyJzdWIiO"
   * }
   *
   * @apiSuccess (字段说明|个人) {string} id_card_front_picture 身份证正面照片
   * @apiSuccess (字段说明|个人) {string} id_card_behind_picture 身份证反面照片
   * @apiSuccess (字段说明|企业) {string} company_name 企业名称
   * @apiSuccess (字段说明|企业) {string} business_license_no 营业执照号
   * @apiSuccess (字段说明|企业) {string} business_license_picture 营业执照图片
   * @apiSuccess (字段说明|项目) {string} project_name 项目名称
   * @apiSuccess (字段说明|项目) {string} project_logo 项目logo
   * @apiSuccess (字段说明|项目) {string} realname 联系人
   * @apiSuccess (字段说明|项目) {string} category_id 项目类型
   * @apiSuccess (字段说明|项目) {string} project_website 项目官网
   * @apiSuccess (字段说明|项目) {string} project_document 白皮书地址
   * @apiSuccess (字段说明|项目) {string} project_social 社交媒体
   * @apiSuccess (字段说明|项目) {string} project_report 审计报告
   * @apiSuccess (字段说明|项目) {string} project_github github地址
   *
   * @apiSampleRequest /api/member/certification/data
   * @apiVersion 1.0.0
   */
  public function data(Request $request)
  {
    try
    {
      $response = '';

      $condition = self::getCurrentWhereData();

      $model = $this->_model::getRow($condition);

      if(empty($model->id))
      {
        return self::error(Code::CERITFICATION_EMPTY);
      }

      if(1 == $model->type['value'])
      {
        $response = $model->personal;
      }
      else if(2 == $model->type['value'])
      {
        $response = $model->company;
      }
      else if(3 == $model->type['value'])
      {
        $response = $model->project;
      }

      return self::success($response);
    }
    catch(\Exception $e)
    {
      // 记录异常信息
      self::record($e);

      return self::error(Code::ERROR);
    }
  }
}
