<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartLineOutputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chart_line_outputs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chart_id')->nullable();
            $table->foreign('chart_id')->references('id')->on('charts')->onDelete('cascade');
            $table->json('output')->nullable();
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
        Schema::dropIfExists('chart_line_outputs');
    }
}
