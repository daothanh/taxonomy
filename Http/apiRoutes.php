<?php

use Illuminate\Routing\Router;

/** @var Router $router */

//Vocabulary routes
$router->group(['prefix' => 'vocabularies', 'middleware' => ['api.token', 'auth.admin']], function (Router $router) {
	$router->bind('vocabulary', function ($id) {
		return app('Modules\Taxonomy\Repositories\VocabularyRepository')->find($id);
	});
	$router->get('/', [
		'as' => 'api.taxonomy.vocabulary.index',
		'uses' => 'VocabularyController@index',
		'middleware' => 'token-can:taxonomy.vocabularies.index',
	]);
	$router->post('/', [
		'as' => 'api.taxonomy.vocabulary.store',
		'uses' => 'VocabularyController@store',
		'middleware' => 'token-can:taxonomy.vocabularies.create',
	]);
	$router->get('all', [
		'as' => 'api.taxonomy.vocabulary.all',
		'uses' => 'VocabularyController@all',
		'middleware' => 'token-can:taxonomy.vocabularies.index',
	]);
	$router->post('find/{vocabulary}', [
		'as' => 'api.taxonomy.vocabulary.find',
		'uses' => 'VocabularyController@find',
		'middleware' => 'token-can:taxonomy.vocabularies.edit',
	]);
	$router->get('get/{vocabulary}', [
		'as' => 'api.taxonomy.vocabulary.get',
		'uses' => 'VocabularyController@get',
		'middleware' => 'token-can:taxonomy.vocabularies.index',
	]);
	$router->post('{vocabulary}/edit', [
		'as' => 'api.taxonomy.vocabulary.update',
		'uses' => 'VocabularyController@update',
		'middleware' => 'token-can:taxonomy.vocabularies.edit',
	]);

	$router->post('find-new', [
		'as' => 'api.taxonomy.vocabulary.find-new',
		'uses' => 'VocabularyController@findNew',
		'middleware' => 'token-can:taxonomy.vocabularies.edit',
	]);

	$router->delete('{vocabulary}', [
		'as' => 'api.taxonomy.vocabulary.destroy',
		'uses' => 'VocabularyController@destroy',
		'middleware' => 'token-can:taxonomy.vocabularies.destroy',
	]);
});

//Term routes
$router->group(['prefix' => 'terms', 'middleware' => ['api.token', 'auth.admin']], function (Router $router) {
	$router->bind('term', function ($id) {
		return app('Modules\Taxonomy\Repositories\TermRepository')->find($id);
	});
	$router->get('/', [
		'as' => 'api.taxonomy.term.index',
		'uses' => 'TermController@index',
		'middleware' => 'token-can:taxonomy.terms.index',
	]);
	$router->post('/', [
		'as' => 'api.taxonomy.term.store',
		'uses' => 'TermController@store',
		'middleware' => 'token-can:taxonomy.terms.create',
	]);
	$router->get('all', [
		'as' => 'api.taxonomy.term.all',
		'uses' => 'TermController@all',
		'middleware' => 'token-can:taxonomy.terms.index',
	]);
	$router->post('find/{term}', [
		'as' => 'api.taxonomy.term.find',
		'uses' => 'TermController@find',
		'middleware' => 'token-can:taxonomy.terms.edit',
	]);

	$router->post('{term}/edit', [
		'as' => 'api.taxonomy.term.update',
		'uses' => 'TermController@update',
		'middleware' => 'token-can:taxonomy.terms.edit',
	]);

	$router->post('find-new', [
		'as' => 'api.taxonomy.term.find-new',
		'uses' => 'TermController@findNew',
		'middleware' => 'token-can:taxonomy.terms.edit',
	]);

	$router->delete('{term}', [
		'as' => 'api.taxonomy.term.destroy',
		'uses' => 'TermController@destroy',
		'middleware' => 'token-can:taxonomy.terms.destroy',
	]);

	$router->get('mark-terms-status', [
		'as' => 'api.taxonomy.term.mark-status',
		'uses' => 'TermController@markStatus',
		'middleware' => 'token-can:taxonomy.terms.edit',
	]);

	$router->get('/get/all', [
		'as' => 'api.taxonomy.term.get.all',
		'uses' => 'TermController@get',
	]);
	$router->get('/get/by', [
		'as' => 'api.taxonomy.term.get.by',
		'uses' => 'TermController@getBy',
	]);
});