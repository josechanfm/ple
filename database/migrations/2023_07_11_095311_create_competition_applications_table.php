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
        Schema::create('competition_applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('competition_id');
            $table->bigInteger('organization_id')->nullable();
            $table->bigInteger('member_id')->nullable();
            $table->string('name_zh')->nullable();
            $table->string('name_fn')->nullable();
            $table->string('given_name')->nullable();
            $table->string('family_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('display_name')->nullable();
            $table->char('gender',1)->nullable();
            $table->date('dob')->nullable();
            $table->string('belt_rank')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('category')->nullable();
            $table->string('weight')->nullable();
            $table->string('role')->nullable();
            $table->string('staff_options')->nullable();
            $table->string('referee_options')->nullable();
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
        Schema::dropIfExists('competition_applications');
    }
};
