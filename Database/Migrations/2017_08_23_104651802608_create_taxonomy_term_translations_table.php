<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxonomyTermTranslationsTable extends Migration
{

  /**
   * Run the migrations.
   *
   * @return void
   */
    public function up()
    {
        Schema::create('taxonomy__term_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('slug');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('og_title')->nullable();
            $table->string('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('og_type')->nullable();

            $table->integer('term_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['term_id', 'locale']);
            $table->foreign('term_id')
                  ->references('id')
                  ->on('taxonomy__terms')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('taxonomy__term_translations', function (Blueprint $table) {
            $table->dropForeign(['term_id']);
        });
        Schema::dropIfExists('taxonomy__term_translations');
    }
}
