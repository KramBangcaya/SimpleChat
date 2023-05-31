<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrars', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128);
            $table->string('first_name', 128);
            $table->string('last_name', 128);
            $table->string('middle_name', 128);
            $table->string('extension_name', 128);
            $table->bigInteger('program_id');
            $table->string('category',32);
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
        Schema::dropIfExists('registrars');
    }
}
