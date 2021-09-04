<?php

return [

  // 上传方式 1 本地 2 OSS 3 OBS
  'type' => 2,

  // 系统访问地址
  'base_url' => 'http://api.bitcodeman.com',

  // 本地
  'local' => [],


  // 阿里云
  'oss' => [
    'access_key_id'     => '必填',
    'access_key_secret' => '必填',
    'bucket'            => '必填',
    'endpoint'          => '必填',
  ],


  // 华为云
  'obs' => [
    'access_key_id'     => '必填',
    'access_key_secret' => '必填',
    'bucket'            => '必填',
    'endpoint'          => '必填',
  ],
];
