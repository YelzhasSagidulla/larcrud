<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRezumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('rezumes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('jobname');
            $table->string('vacancy');
            $table->string('experience');
            $table->string('fullname');
            $table->string('educationlevel');
            $table->string('educationname');
            $table->string('skills');
            $table->string('contacts');
            $table->rememberToken();
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
        //
    }
}
