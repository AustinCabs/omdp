<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->increments('id');

            $table->string('otp_no')->nullable();
            $table->string('tax_acc_no')->nullable();
            $table->integer('commodity'); #1 ore ,2 minerals

            $table->string('volume');
            $table->float('value');
            $table->float('excise_tax');
            $table->string('source');
            $table->string('destination');
            $table->string('date_issued'); #expiry date 15 days from date issued
            
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
        Schema::dropIfExists('otps');
    }
}
