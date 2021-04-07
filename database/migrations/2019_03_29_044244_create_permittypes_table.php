<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermittypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permittypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('validity_type');
            $table->string('validity_unit');
            $table->string('doc_name');
            $table->integer('type')->default(0); #0 mining 1 quarry
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
        Schema::dropIfExists('permittypes');
    }
}
