<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/taxonomy'], function (Router $router) {
    $router->bind('vocabulary', function ($id) {
        return app('Modules\Taxonomy\Repositories\VocabularyRepository')->find($id);
    });
    $router->get('vocabularies', [
        'as' => 'admin.taxonomy.vocabulary.index',
        'uses' => 'VocabularyController@index',
        'middleware' => 'can:taxonomy.vocabularies.index'
    ]);
    $router->get('vocabularies/create', [
        'as' => 'admin.taxonomy.vocabulary.create',
        'uses' => 'VocabularyController@create',
        'middleware' => 'can:taxonomy.vocabularies.create'
    ]);
    $router->post('vocabularies', [
        'as' => 'admin.taxonomy.vocabulary.store',
        'uses' => 'VocabularyController@store',
        'middleware' => 'can:taxonomy.vocabularies.create'
    ]);
    $router->get('vocabularies/{vocabulary}/edit', [
        'as' => 'admin.taxonomy.vocabulary.edit',
        'uses' => 'VocabularyController@edit',
        'middleware' => 'can:taxonomy.vocabularies.edit'
    ]);
    $router->put('vocabularies/{vocabulary}', [
        'as' => 'admin.taxonomy.vocabulary.update',
        'uses' => 'VocabularyController@update',
        'middleware' => 'can:taxonomy.vocabularies.edit'
    ]);
    $router->delete('vocabularies/{vocabulary}', [
        'as' => 'admin.taxonomy.vocabulary.destroy',
        'uses' => 'VocabularyController@destroy',
        'middleware' => 'can:taxonomy.vocabularies.destroy'
    ]);
    $router->bind('term', function ($id) {
        return app('Modules\Taxonomy\Repositories\TermRepository')->find($id);
    });
    $router->get('vocabularies/{vocabulary}/terms', [
        'as' => 'admin.taxonomy.term.index',
        'uses' => 'TermController@index',
        'middleware' => 'can:taxonomy.terms.index'
    ]);
    $router->get('vocabularies/{vocabulary}/terms/create', [
        'as' => 'admin.taxonomy.term.create',
        'uses' => 'TermController@create',
        'middleware' => 'can:taxonomy.terms.create'
    ]);
    $router->post('vocabularies/{vocabulary}/terms', [
        'as' => 'admin.taxonomy.term.store',
        'uses' => 'TermController@store',
        'middleware' => 'can:taxonomy.terms.create'
    ]);
    $router->get('vocabularies/{vocabulary}/terms/{term}/edit', [
        'as' => 'admin.taxonomy.term.edit',
        'uses' => 'TermController@edit',
        'middleware' => 'can:taxonomy.terms.edit'
    ]);
    $router->put('vocabularies/{vocabulary}/terms/{term}', [
        'as' => 'admin.taxonomy.term.update',
        'uses' => 'TermController@update',
        'middleware' => 'can:taxonomy.terms.edit'
    ]);
    $router->delete('vocabularies/{vocabulary}/terms/{term}', [
        'as' => 'admin.taxonomy.term.destroy',
        'uses' => 'TermController@destroy',
        'middleware' => 'can:taxonomy.terms.destroy'
    ]);
});
