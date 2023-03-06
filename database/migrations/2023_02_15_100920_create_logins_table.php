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
        Schema::create('logins', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->ipAddress('ip');
            $table->string('country');
            $table->string('country_code');
            $table->string('region');
            $table->integer('region_code');
            $table->string('city');
            $table->integer('zip');
            $table->double('lat')->nullable();
            $table->double('long')->nullable();
            $table->date('login_date_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logins');
    }
};
