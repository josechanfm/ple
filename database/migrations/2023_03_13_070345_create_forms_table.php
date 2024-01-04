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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->unsigned();
            $table->string('name');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->boolean('require_login')->default(false);
            $table->boolean('for_member')->default(false);
            $table->boolean('published')->default(false);
            $table->boolean('with_attendance')->nullable();
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
        Schema::dropIfExists('forms');
    }
};
