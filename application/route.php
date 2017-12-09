<?php

use think\Route;

Route::get('test', 'api/test/index');
Route::get('api/:ver/cat', 'api/:ver.cat/read');