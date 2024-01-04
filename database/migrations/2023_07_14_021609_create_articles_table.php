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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->nullable()->unique();
            $table->foreignId('organization_id');
            $table->string('category_code',5);
            $table->string('title_en');
            $table->string('title_fn')->nullable();
            $table->text('intro_en')->nullable();
            $table->text('intro_fn')->nullable();
            $table->text('content_en')->nullable();
            $table->text('content_fn')->nullable();
            $table->date('valid_at')->nullable();
            $table->date('expire_at')->nullable();
            $table->text('url')->nullable();
            $table->string('reference')->nullable();
            $table->text('author')->nullable();
            $table->foreignId('user_id');
            $table->boolean('public');
            $table->boolean('published');
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
        Schema::dropIfExists('articles');
    }
};
