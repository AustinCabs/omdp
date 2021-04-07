<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->increments('id');

            $table->string('or_no')->nullable();
            $table->float('amount')->nullable();
            $table->string('date_paid')->nullable();

            $table->float('fee', 8, 2);
            $table->string('name');
            
            $table->integer('otps_id')->nullable();
            $table->integer('status')->default(0); #0 pending 1 paid
            $table->integer('type')->default(0); #0 norma 1 penaty
            $table->integer('masterlist_id')->unsigned();
            $table->foreign('masterlist_id')->references('id')->on('masterlists')->onDelete('cascade');
            
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
        Schema::dropIfExists('billings');
    }
}
