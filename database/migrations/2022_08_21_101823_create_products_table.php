<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('init')->nullable()->default(0);
            $table->string('barcode')->nullable();
            $table->string('name');
            $table->string('category_id');
            $table->string('unit_id');
            $table->string('vendor_id');
            $table->string('quantity_initial')->nullable()->default(0);
            $table->double('clients_invoices_qty')->nullable()->default(0);
            $table->double('suppliers_invoices_qty')->nullable()->default(0);
            $table->double('clients_returns_qty')->nullable()->default(0);
            $table->double('suppliers_returns_qty')->nullable()->default(0);
            $table->double('sell_price')->nullable()->default(0);
            $table->double('buy_price')->nullable()->default(0);
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
        Schema::dropIfExists('products');
    }
}
