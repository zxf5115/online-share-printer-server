<?php

return [
  'app_key' => env('JPUSH_APP_KEY'),
  'master_secret' => env('JPUSH_APP_MASTER_SECRET'),

  // 环境 true-生产环境 false-开发环境
  'environment' => env('JPUSH_APNS_PRODUCTION', true)
];
