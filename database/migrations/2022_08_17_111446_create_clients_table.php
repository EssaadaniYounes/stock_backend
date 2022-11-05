<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->integer('init')->nullable()->default(0);
            $table->string('full_name');
            $table->string('street')->nullable()->default('');
            $table->string('zip_code')->nullable()->default('');
            $table->string('city_id')->nullable()->default(1);
            $table->string('address')->nullable()->default('');
            $table->string('tel')->nullable()->default('');
            $table->string('email')->nullable()->default('');
            $table->string('company_id');
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
        Schema::dropIfExists('clients');
    }
}
