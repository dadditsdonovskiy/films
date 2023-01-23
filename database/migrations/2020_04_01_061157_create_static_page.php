<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'static_page',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name')->nullable();
                $table->longText('content')->nullable();
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                $table->string('slug')->unique()->nullable();
                $table->integer('sort_order')->unsigned()->nullable();
                $table->integer('created_at')->unsigned()->nullable();
                $table->integer('updated_at')->unsigned()->nullable();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('static_page');
    }
}
