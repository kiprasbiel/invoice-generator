<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CerateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('sf_code');
            $table->integer('sf_number');
            $table->string('company_name');
            $table->string('company_code');
            $table->string('email')->nullable();
            $table->string('company_vat')->nullable();
            $table->string('company_address')->nullable();
            $table->date('pay_by')->nullable();
            $table->boolean('is_payed');
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
        Schema::dropIfExists('invoices');
    }
}
