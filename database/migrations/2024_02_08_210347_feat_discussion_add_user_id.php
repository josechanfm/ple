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
        // who posted this discussion
        Schema::table('discussions', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // who posted this discussion
        Schema::table('discussions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
