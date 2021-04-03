<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('import_data', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('csv_filename');
            $table->boolean('csv_header')->default(0);
            $table->longText('csv_data')->nullable();
            $table->string('type');
            $table->boolean('is_imported')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('import_data');
    }
}
