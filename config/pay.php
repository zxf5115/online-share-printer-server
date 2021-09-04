<?php

return [

    'wechat' => [
        'appid' => 'wx79c7b997be1d6096', // APP APPID
        'app_id' => 'wxd126b537517b66c7', // 公众号 APPID
        'miniapp_id' => 'wx79c7b997be1d6096', // 小程序 APPID
        'mch_id' => '1605703089',
        'key' => 'a0dccbca7382381b129a2cd34930ca47',
        'notify_url' => 'http://api.xcyys.cn/api/common/wechat/notify',
        'cert_client' => './cert/apiclient_cert.pem', // optional，退款等情况时用到
        'cert_key' => './cert/apiclient_key.pem',// optional，退款等情况时用到
        'log' => [ // optional
            'file' => './logs/wechat.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'normal', // optional, dev/hk;当为 `hk` 时，为香港 gateway。
    ],

    'alipay' => [
        'app_id' => '2021002129687181',
        'notify_url' => 'http://api.xcyys.cn/api/common/alipay/notify',
        'return_url' => '',
        'ali_public_key' => './cert/alipayCertPublicKey_RSA2.crt',
        // // 加密方式： **RSA2**
        'private_key' => 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCvbhlOgd6UKEFWSVVm5cun1ADUAqdL314M3XTWsVWydgJRkvSu+p77yrfc/ZUNe/7YvmuIKwEG88fV9PPxgu51Pk32eu/6KYsxX92qdzpocCL4An5dE9264879JEAuwHiX1WzmozRQo2fUiKyhKyH7fY5v4Ia59EUXNuk2ncK6srP5OzTzmzCYE9bgA9mbu/9fdaoIxyeq5VButpWsylEw+q2irYzBEVulkmyig+5m4belPU4I3+Oj6oe7EZzANVpoMGxNG3yxgFEooNjRWbSzDzdTUk0Pz5Dyse1zB7ZlQlwVdvsFjOe/FnXlNSXQzXyg5w55MG5motsM5RHC9PD9AgMBAAECggEAP3sEt07xXwVuFy40NCblWhayMgW/ygnK+7bLR8El9I0Va7VUy1ivXQfPHq24WQfMgVvuh3igR4bBgl/AQl2RsmVYSt/TpN+Rmc1J5hx8yzwAu2QTm9TLgIxc42dRvlkxiifV32OhU6i9sr++UBfOlTWq7DsAJZwJwEvDelr+ExZp1ywz1hutubMYTSFZhgQzFr05BBsSdPWgFOIxncSX/kxP2tfH83XCzkTSID7JA1dyUDVeOIed3uy2DtUJrY42klqFeOAaP46jcEu61fbqEid+EpWe8ZRsxoW9B79bYfN9KLRsHRhe1Tz57GvEFoTLPHgax+wot1EhnGJCA9C+gQKBgQD6nRTHrIGkapsxJNi221TghP0al8Cf6kskjPWbBZrKHgInGqWWHW8AOUdk0B22Nqnqoou1G8I3m/9hpp9acOBMIQ/L/KQIZKsOU9vWr+hlvCZYDPGEzx9fSdV0AT2N89kW7uLRCzioZwh61cWDmjA0mqaY1MOH6nr5ipunVjZPIQKBgQCzM1hXmSriyp0ql37J8DdaJnPbPUutEeA1Pw0Ae5J50bZtTVfpkGPc4qmnbFA0u42R1juw+nBCVSkGaaYqfXL0xjbazq9F7dmv3uSwlu+/ixWlk1lDaLYrpb8r0wEEGq0J/igTuVxEz3Vkx+QgUNYbrSL3HZDfaMJS3DLUHc3yXQKBgDBP++OKU+u4SXat3cFSgwhNWuW3f4DUj+vZ6Lcb230/T7buIiHQRsfKQwMiQ7gOza7X6wrc8RH7Vr4ievHadML4VK1EZPLhRUCb1fOLMcf6/4FV7XFm5GtgNnAIlS86ZQ1QvBUEjsWYJ0BW2Z7HKKfbcGZiDdez0kUs/VjC+/FBAoGAWWWF7r1UbatSWIsXDzqtAmYoafjcJczDIwz/OXxsCCWcck6hSr1jdDAHHqSkJopiB5zuTk3BbvX472AJKy1GCeJQPzvYqHQNovT49Td3BwElnWIyp7Q3HPMkuYIcAaYlKNUHvT89Tn6IO+yUW6K4DTqENO8k9K7YMmnzWWo88WkCgYEAh2LQDqzS/oA83xywNMLQT7IThwQU0JIA2KumC58O6Bk0dEo9O2qfKfFgrvDvTvxM1d0JoCfTq5wV/brArw7hshk3RlRXCZCsrJf1SlGKc4ESn3KxnSekD7JQP+a95Uad4rAqPyLkfeXooT7VH8Kt6VLduEv9HZuYVOB+/h0UG9g=',
        'app_cert_public_key' => './cert/appCertPublicKey_2021002129687181.crt', //应用公钥证书路径
        'alipay_root_cert' => './cert/alipayRootCert.crt', //支付宝根证书路径
        'log' => [ // optional
            'file' => './logs/alipay.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        'mode' => 'normal', // optional,设置此参数，将进入沙箱模式
    ]
];
