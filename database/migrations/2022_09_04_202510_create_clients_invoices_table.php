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
            $table->string('notes');
            $table->string('invoice_date');
            $table->double('total');
            $table->json('products');
            /*products=[
                 {
                    product_id,
                    name,
                    quantity,
                    price,
                    amount
                }
            ]*/
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
