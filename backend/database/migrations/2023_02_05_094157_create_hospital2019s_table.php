<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospital2019sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('2019', function (Blueprint $table) {
            $table->id();
            $table->string('DATA_SOURCE')->nullable();
            $table->string('IncidentTypeName')->nullable();
            $table->bigInteger('IncidentCode')->nullable();
            $table->bigInteger('IncidentID')->nullable();
            $table->bigInteger('patientid')->nullable();
            $table->boolean('transport')->default(false);
            $table->date('INCIDENT_DATE')->nullable();
            $table->time('RINGTIME')->nullable();
            $table->time('ANSWERTIME')->nullable();
            $table->time('DISPATCHINGTIME')->nullable();
            $table->integer('DISPATCHINGTIME_ANSWERTIME_SECOND')->nullable();
            $table->integer('DISPATCHINGTIME_ANSWERTIME_MINUTE')->nullable();
            $table->time('ACCEPTREFUSETIME')->nullable();
            $table->time('MOVEMENTTIME', $precision = 2)->nullable();
            $table->integer('MOVEMENTTIME_ACCEPTREFUSETIME_SECOND')->nullable();
            $table->time('ReachSiteTime')->nullable();
            $table->integer('ReachSiteTime_ACCEPTREFUSETIME_SECOND')->nullable();
            $table->integer('ReachSiteTime_ACCEPTREFUSETIME_MINUTE')->nullable();
            $table->integer('ReachSiteTime_AnswerTime_MINUTE')->nullable();
            $table->time('CaseTreatmentTime')->nullable();
            $table->integer('CaseTreatmentTime_ReachSiteTime_SECOND')->nullable();
            $table->integer('CaseTreatmentTime_ReachSiteTime_MINUTE')->nullable();
            $table->time('MoveFromSiteTime')->nullable();
            $table->integer('MoveFromSiteTime_CaseTreatmentTime_MINUTE')->nullable();
            $table->time('ReachHospital')->nullable();
            $table->integer('ReachHospital_MoveFromSiteTime_MINUTE')->nullable();
            $table->time('LeaveHospital')->nullable();
            $table->string('SourceName')->nullable();
            $table->string('IncidentPriorityName')->nullable();
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
        Schema::dropIfExists('2019');
    }
}
