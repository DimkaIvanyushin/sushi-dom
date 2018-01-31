<?php


Route::auth();

Route::get('/', [
	'uses' => 'HomeController@index',
	'as' => 'home.index'
]);

Route::group(['prefix' => 'products'], function() {
	Route::post('/create', [
		'uses' => 'ProductController@create',
		'as' => 'product.create'
	]);

	Route::get('/{product}', [
		'uses' => 'ProductController@show',
		'as' => 'product.show'
	]);

	Route::get('/{product}/edit', [
		'uses' => 'ProductController@edit',
		'as' => 'product.edit'
	]);

	Route::put('/{product}/update', [
		'uses' => 'ProductController@update',
		'as' => 'product.update'
	]);

	Route::delete('/{product}', [
		'uses' => 'ProductController@destroy',
		'as' => 'product.destroy'
	]);

	Route::get('/{product}/like', [
		'uses' => 'ProductController@like',
		'as' => 'product.like'
	]);

});

Route::group(['prefix' => 'cart'], function() {

	Route::get('/get', [
		'uses' => 'CartController@get',
		'as' => 'cart.get'
	]);

	Route::post('/postCheckout', [
		'uses' => 'CartController@postCheckout',
		'as' => 'cart.postCheckout'
	]);

	Route::get('/add/{id}',[
		'uses' => 'CartController@add',
		'as' => 'cart.add'
	]);

	Route::get('/destroy/{id}',[
		'uses' => 'CartController@destroy',
		'as' => 'cart.destroy'
	]);

});

Route::resource('category', 'CategoryController');
