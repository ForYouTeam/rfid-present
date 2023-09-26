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
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->string('rfid', 25 );
            $table->string('name', 150);
            $table->string('nirp', 25 );
            $table->string('nik' , 25 );
            $table->string('sex' , 25 );
            $table->foreignId('position_id')->nullable()->constrained('positions')->onDelete('set null');
            $table->foreignId('satker_id')->nullable()->constrained('satkers')->onDelete('set null');
            $table->string('kls' , 150 );
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
        Schema::dropIfExists('employes');
    }
};
