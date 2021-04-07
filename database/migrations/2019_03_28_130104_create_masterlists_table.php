<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('masterlists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('permit_no');
            $table->string('img')->nullable();
            
            $table->string('owner_name');
            $table->string('business_name');
            #address
            $table->string('prk');
            $table->string('brgy');
            $table->string('municipality');
            $table->string('province');
            $table->string('island');

            $table->string('date_filed');
            $table->string('tin_no');
            $table->string('contact_no');

            $table->string('date_issued')->nullable();
            $table->integer('type'); #Sand and gravel or something
            $table->float('area_volume')->nullable();
            $table->float('total_hectares')->nullable();
            $table->string('expiry_date')->nullable();

            $table->string('longhitude')->nullable();
            $table->string('latitude')->nullable();

            $table->integer('status')->default(0);# 0 pending, 1 approved, 2 declined

            $table->string('remarks')->nullable();

            $table->string('query_code')->nullable();

            $table->integer('permittype_id');

            $table->integer('application_type')->default(0); # 0 is new 1 is renewal

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
        Schema::dropIfExists('masterlists');
    }
}
