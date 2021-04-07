<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('materials');
            $table->string('p_quantity')->nullable();
            $table->string('p_value')->nullable();
            $table->string('s_quantity')->nullable();
            $table->string('s_value')->nullable();

            $table->string('m_inventory_q')->nullable();
            $table->string('m_inventory_v')->nullable();

            $table->string('fee_payable')->nullable();
            $table->string('tax_payable')->nullable();

            $table->string('buyer_address')->nullable();

            $table->integer('report_id');
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
        Schema::dropIfExists('productions');
    }
}
