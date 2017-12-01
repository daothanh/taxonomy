<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxonomyVocabularyTranslationsTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up() {
    Schema::create('taxonomy__vocabulary_translations', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id');
      $table->string('name');
      $table->text('description')->nullable();
      $table->integer('vocabulary_id')->unsigned();
      $table->string('locale')->index();
      $table->unique(['vocabulary_id', 'locale']);
      $table->foreign('vocabulary_id')
        ->references('id')
        ->on('taxonomy__vocabularies')
        ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down() {
    Schema::table('taxonomy__vocabulary_translations', function (Blueprint $table) {
      $table->dropForeign(['vocabulary_id']);
    });
    Schema::dropIfExists('taxonomy__vocabulary_translations');
  }
}
