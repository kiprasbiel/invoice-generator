<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('expenses', function(Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('number');
            $table->integer('total_price');
            $table->datetime('date');
            $table->string('currency');
            $table->string('seller_name');
            $table->string('seller_code');
            $table->string('seller_address')->nullable();
            $table->string('seller_vat')->nullable();
            $table->string('seller_country')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('expenses');
    }
}
