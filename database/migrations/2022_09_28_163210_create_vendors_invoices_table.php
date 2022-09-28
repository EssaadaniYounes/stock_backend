<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('company_id');
            $table->string('vendor_id');
            $table->string('invoice_num')->nullable();
            $table->string('notes')->nullable();
            $table->dateTime('invoice_date')->nullable();
            $table->double('total_amount')->default(0);
            $table->double('total_discount')->default(0);
            $table->double('total_tax')->default(0);
            $table->double('total_with_tax')->default(0);
            $table->double('paid_amount')->default(0);
            $table->double('rest_amount')->default(0);
            $table->integer('method_id')->default(1);
            $table->string('created_by');
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
        Schema::dropIfExists('vendors_invoices');
    }
}
