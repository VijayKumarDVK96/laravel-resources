<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 40);
            $table->string('last_name', 40)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('contact_number', 100)->nullable();
            $table->integer('gender')->nullable()->comment('Male - 1, Female - 2');
            $table->string('specialization', 200)->nullable();
            $table->integer('work_ex_year')->nullable();
            $table->integer('candidate_dob')->nullable();
            $table->string('address', 500)->nullable();
            $table->string('resume')->nullable();
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
        Schema::dropIfExists('candidates');
    }
}
