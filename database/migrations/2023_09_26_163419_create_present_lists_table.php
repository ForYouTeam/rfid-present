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
        Schema::create('present_lists', function (Blueprint $table) {
            $table->id();
            $table->date('present_date');
            $table->time('start_in');
            $table->time('start_out');
            $table->string('status', 2);
            $table->foreignId('employe_id')->nullable()->constrained('employes')->onDelete('set null');
            $table->foreignId('grouping_by')->nullable()->constrained('satkers')->onDelete('set null');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('present_lists');
    }
};
