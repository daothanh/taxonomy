<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxonomyTermsHierarchyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxonomy__terms_hierarchy', function (Blueprint $table) {
          $table->unsignedInteger('term_id');
          $table->unsignedInteger('parent_id');

          $table->primary(array('term_id', 'parent_id'));
          $table->index('parent_id', 'parent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taxonomy__terms_hierarchy');
    }
}
