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
        Schema::create('comparison_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('criteria_id')->constrained('criteria')->onDelete('cascade');
            $table->foreignId('alternative_id')->constrained('alternatives')->onDelete('cascade');
            $table->decimal('comparison_result', 8, 2);
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
        Schema::dropIfExists('comparison_details');
    }
};
