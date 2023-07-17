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
            $table->bigInteger('organization_id');
            $table->bigInteger('classify_id');
            $table->string('title_en');
            $table->string('title_fn')->nullable();
            $table->text('intro_en')->nullable();
            $table->text('intro_fn')->nullable();
            $table->text('content_en')->nullable();
            $table->text('content_fn')->nullable();
            $table->boolean('published');
            $table->date('validated_at')->nullable();
            $table->date('expired_at')->nullable();
            $table->text('url')->nullable();
            $table->string('reference')->nullable();
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
