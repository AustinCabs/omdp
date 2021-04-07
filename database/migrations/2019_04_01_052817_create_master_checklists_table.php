<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterChecklistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_checklists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status')->default(0);# 0 pending 1 done
            $table->string('name');
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
        Schema::dropIfExists('master_checklists');
    }
}
