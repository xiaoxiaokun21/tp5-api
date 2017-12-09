<?php

use think\Route;

Route::get('test', 'api/test/index');
Route::get('api/:ver/cat', 'api/:ver.cat/read');
Route::get('api/:ver/index', 'api/:ver.index/index');

//news
Route::resource('api/:ver/news', 'api/:ver.news');

//排行
Route::get('api/:ver/rank', 'api/:ver.rank/index');