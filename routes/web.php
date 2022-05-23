<?php

Route::any('/api/shorten', 'UrlController@shorten');
Route::any('/api/expand', 'UrlController@expand');
Route::any('/api/delete', 'UrlController@delete');

Route::get('/k/{key}', 'UrlController@to');
