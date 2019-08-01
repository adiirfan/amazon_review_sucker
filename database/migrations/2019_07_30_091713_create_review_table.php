<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ASIN');
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->string('reviewUrl')->nullable();
            $table->tinyInteger('verif')->default(0);
            $table->float('rating')->nullable();
            $table->string('author')->nullable();
            $table->string('authorUrl')->nullable();
            $table->date('reviewDate')->nullable();
            $table->integer('comment')->default( 0);
            $table->tinyInteger('isVideo')->default(0);
            $table->tinyInteger('isImage')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review');
    }
}
