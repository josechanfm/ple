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
        Schema::create('certificate_member', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_id')->reference('id')->on('certificates')->onDelete('restric')->onUpdate('cascade');
            $table->foreignId('member_id');
            $table->integer('number')->nullable();
            $table->integer('number_display')->nullable();
            $table->string('display_name');
            $table->string('avatar')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->string('authorized_by')->nullable();
            $table->string('rank')->nullable();
            $table->text('extra')->nullable();
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('certificate_member');
    }
};
