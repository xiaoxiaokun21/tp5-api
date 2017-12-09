<?php
return [
    'password_pre_halt'   => '#yangze',//密码盐
    'aeskey'              => 'yangzeyangzeyang', //aes加密 16 24位数
    'apptypes'            => ['ios', 'android'],
    'app_sign_time'       => 10,//sign失效时间
    'app_sign_cache_time' => 20//sign缓存失效时间
];