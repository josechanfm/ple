<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id');
            $table->text('modules')->nullable();
            $table->string('title');
            $table->text('learn')->nullable();
            $table->text('brief')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->date('start_on')->nullable();
            $table->date('finish_on')->nullable();
            $table->boolean('published')->default(0);
            $table->foreignId('user_id');
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
        Schema::dropIfExists('courses');
    }
};
