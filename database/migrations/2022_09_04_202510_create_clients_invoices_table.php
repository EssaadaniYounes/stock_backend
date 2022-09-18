<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('client_id');
            $table->string('invoice_num');
            $table->string('notes')->nullable();
            $table->string('invoice_date');
            $table->double('total');
            $table->double('discount')->nullable();
            $table->string('created_by');
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
        Schema::dropIfExists('clients_invoices');
    }
}
