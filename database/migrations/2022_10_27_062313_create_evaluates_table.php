<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('period_id')->constrained()->onDelete('cascade');
            $table->integer('subject_id')->nullable();
            $table->unsignedBigInteger('evaluator');
            $table->foreign('evaluator')->references('id')->on('users');
            $table->unsignedBigInteger('evaluatee');
            $table->foreign('evaluatee')->references('id')->on('users');
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('evaluates');
    }
};
