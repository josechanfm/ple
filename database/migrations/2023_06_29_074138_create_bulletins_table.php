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
        Schema::create('bulletins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id');
            $table->string('category');
            $table->date('date');
            $table->string('title');
            $table->string('description')->nullable();
            $table->text('content')->nullable();
            $table->boolean('published')->default(1);
            $table->string('post_id')->nullable();
            $table->text('cover_image_path')->nullable();
            $table->foreignId('created_by');
            $table->foreignId('updated_by');
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
        Schema::dropIfExists('bulletins');
    }
};
