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
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id');
            $table->string('title_zh');
            $table->string('title_fn')->nullable();
            $table->text('brief')->nullable();
            $table->text('description')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->text('match_dates')->nullable();
            $table->text('categories_weights');
            $table->text('roles')->nullable();
            $table->text('scope')->nullable();
            $table->boolean('for_member')->nullable();
            $table->text('staff_options')->nullable();
            $table->text('referee_options')->nullable();
            $table->string('fee')->nullable();
            $table->boolean('published')->default(false);
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
        Schema::dropIfExists('competitions');
    }
};
