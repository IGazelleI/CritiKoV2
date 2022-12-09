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
        Schema::create('sasts', function (Blueprint $table) {
            $table->id();
            $table->string('fname')->nullable();
            $table->string('mname')->nullable();
            $table->string('lname')->nullable();
            $table->string('suffix')->nullable();
            $table->string('address')->nullable();
            $table->date('dob')->nullable();
            $table->string('cnumber')->nullable();
            $table->string('imgPath')->nullable();
            $table->string('emergency_cPName')->nullable();
            $table->string('emergency_cPNumber')->nullable();
            $table->string('emergency_cPRelationship')->nullable();
            $table->string('emergency_cPAddress')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('sasts');
    }
};
