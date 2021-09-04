<?php
namespace App\Enum\Common;

/**
 * @author zhangxiaofei [<1326336909@qq.com>]
 * @dateTime 2020-09-25
 *
 * 民族枚举类
 */
class NationalEnum
{

  // 状态封装
  const A  = 1; // 汉族
  const B  = 2; // 蒙古族
  const C  = 3; // 回族
  const D  = 4; // 藏族
  const E  = 5; // 维吾尔族
  const F  = 6; // 苗族
  const G  = 7; // 彝族
  const H  = 8; // 壮族
  const I  = 9; // 布依族
  const J  = 10; // 朝鲜族
  const K  = 11; // 满族
  const L  = 12; // 侗族
  const M  = 13; // 瑶族
  const N  = 14; // 白族
  const O  = 15; // 土家族
  const P  = 16; // 哈尼族
  const Q  = 17; // 哈萨克族
  const R  = 18; // 傣族
  const S  = 19; // 黎族
  const T  = 20; // 傈僳族
  const U  = 21; // 佤族
  const V  = 22; // 畲族
  const W  = 23; // 高山族
  const X  = 24; // 拉祜族
  const Y  = 25; // 水族
  const Z  = 26; // 东乡族
  const BA = 27; // 纳西族
  const BB = 28; // 景颇族
  const BC = 29; // 柯尔克孜族
  const BD = 30; // 土族
  const BE = 31; // 达斡尔族
  const BF = 32; // 仫佬族
  const BG = 33; // 羌族
  const BH = 34; // 布朗族
  const BI = 35; // 撒拉族
  const BJ = 36; // 毛南族
  const BK = 37; // 仡佬族
  const BL = 38; // 锡伯族
  const BM = 39; // 阿昌族
  const BN = 40; // 普米族
  const BO = 41; // 塔吉克族
  const BP = 42; // 怒族
  const BQ = 43; // 乌孜别克族
  const BR = 44; // 俄罗斯族
  const BS = 45; // 鄂温克族
  const BT = 46; // 德昂族
  const BU = 47; // 保安族
  const BV = 48; // 裕固族
  const BW = 49; // 京族
  const BX = 50; // 塔塔尔族
  const BY = 51; // 独龙族
  const BZ = 52; // 鄂伦春族
  const CA = 53; // 赫哲族
  const CB = 54; // 门巴族
  const CC = 55; // 珞巴族
  const CD = 56; // 基诺族

  // 民族封装
  public static $national = [
    self::A       => [
      'value' => self::A,
      'text' => '汉族'
    ],

    self::B       => [
      'value' => self::B,
      'text' => '蒙古族'
    ],

    self::C       => [
      'value' => self::C,
      'text' => '回族'
    ],

    self::D       => [
      'value' => self::D,
      'text' => '藏族'
    ],

    self::E       => [
      'value' => self::E,
      'text' => '维吾尔族'
    ],

    self::F       => [
      'value' => self::F,
      'text' => '苗族'
    ],

    self::G       => [
      'value' => self::G,
      'text' => '彝族'
    ],

    self::H       => [
      'value' => self::H,
      'text' => '壮族'
    ],

    self::I       => [
      'value' => self::I,
      'text' => '布依族'
    ],

    self::J       => [
      'value' => self::J,
      'text' => '朝鲜族'
    ],

    self::K       => [
      'value' => self::K,
      'text' => '满族'
    ],

    self::L       => [
      'value' => self::L,
      'text' => '侗族'
    ],

    self::M       => [
      'value' => self::M,
      'text' => '朝鲜族'
    ],

    self::N       => [
      'value' => self::N,
      'text' => '白族'
    ],

    self::O       => [
      'value' => self::O,
      'text' => '土家族'
    ],

    self::P       => [
      'value' => self::P,
      'text' => '哈尼族'
    ],

    self::Q       => [
      'value' => self::Q,
      'text' => '哈萨克族'
    ],

    self::R       => [
      'value' => self::R,
      'text' => '傣族'
    ],

    self::S       => [
      'value' => self::S,
      'text' => '黎族'
    ],

    self::T       => [
      'value' => self::T,
      'text' => '傈僳族'
    ],

    self::U       => [
      'value' => self::U,
      'text' => '佤族'
    ],

    self::V       => [
      'value' => self::V,
      'text' => '畲族'
    ],

    self::W       => [
      'value' => self::W,
      'text' => '高山族'
    ],

    self::X       => [
      'value' => self::X,
      'text' => '拉祜族'
    ],

    self::Y       => [
      'value' => self::Y,
      'text' => '水族'
    ],

    self::Z       => [
      'value' => self::Z,
      'text' => '东乡族'
    ],

    self::BA       => [
      'value' => self::BA,
      'text' => '纳西族'
    ],

    self::BB       => [
      'value' => self::BB,
      'text' => '景颇族'
    ],

    self::BC       => [
      'value' => self::BC,
      'text' => '柯尔克孜族'
    ],

    self::BD       => [
      'value' => self::BD,
      'text' => '土族'
    ],

    self::BE       => [
      'value' => self::BE,
      'text' => '达斡尔族'
    ],

    self::BF       => [
      'value' => self::BF,
      'text' => '仫佬族'
    ],

    self::BG       => [
      'value' => self::BG,
      'text' => '羌族'
    ],

    self::BH       => [
      'value' => self::BH,
      'text' => '布朗族'
    ],

    self::BI       => [
      'value' => self::BI,
      'text' => '撒拉族'
    ],

    self::BJ       => [
      'value' => self::BJ,
      'text' => '毛南族'
    ],

    self::BK       => [
      'value' => self::BK,
      'text' => '仡佬族'
    ],

    self::BL       => [
      'value' => self::BL,
      'text' => '锡伯族'
    ],

    self::BM       => [
      'value' => self::BM,
      'text' => '阿昌族'
    ],

    self::BN       => [
      'value' => self::BN,
      'text' => '普米族'
    ],

    self::BO       => [
      'value' => self::BO,
      'text' => '塔吉克族'
    ],

    self::BP       => [
      'value' => self::BP,
      'text' => '怒族'
    ],

    self::BQ       => [
      'value' => self::BQ,
      'text' => '乌孜别克族'
    ],

    self::BR       => [
      'value' => self::BR,
      'text' => '俄罗斯族'
    ],

    self::BS       => [
      'value' => self::BS,
      'text' => '鄂温克族'
    ],

    self::BT       => [
      'value' => self::BT,
      'text' => '德昂族'
    ],

    self::BU       => [
      'value' => self::BU,
      'text' => '保安族'
    ],

    self::BV       => [
      'value' => self::BV,
      'text' => '裕固族'
    ],

    self::BW       => [
      'value' => self::BW,
      'text' => '京族'
    ],

    self::BX       => [
      'value' => self::BX,
      'text' => '塔塔尔族'
    ],

    self::BY       => [
      'value' => self::BY,
      'text' => '独龙族'
    ],

    self::BZ       => [
      'value' => self::BZ,
      'text' => '鄂伦春族'
    ],

    self::CA       => [
      'value' => self::CA,
      'text' => '赫哲族'
    ],

    self::CB       => [
      'value' => self::CB,
      'text' => '门巴族'
    ],

    self::CC       => [
      'value' => self::CC,
      'text' => '珞巴族'
    ],

    self::CD       => [
      'value' => self::CD,
      'text' => '基诺族'
    ],
  ];


  /**
   * @author zhangxiaofei [<1326336909@qq.com>]
   * @dateTime 2020-09-25
   * ------------------------------------------
   * 民族类型封装
   * ------------------------------------------
   *
   * 民族类型封装
   *
   * @param int $code 状态代码
   * @return 状态信息
   */
  public static function getNational($code)
  {
    return self::$national[$code] ?: self::$national[self::A];
  }
}
