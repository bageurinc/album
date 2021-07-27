<?php
Route::name('bageur.')->group(function () {
	Route::group(['prefix' => 'bageur/v1','middleware' => 'api'], function () {
		// Route::apiResource('artikel', 'bageur\artikel\ArtikelController');
		Route::apiResource('album', 'bageur\album\AlbumController');
		Route::apiResource('album-detail', 'bageur\album\AlbumdetailController')->except(['update']);
		Route::apiResource('komentar', 'bageur\album\KomentarController');
        Route::post('urutan-album-detail', 'bageur\album\AlbumdetailController@urutan');
	});
});
