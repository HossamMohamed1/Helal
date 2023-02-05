<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hospital2018 extends Model
{
    use HasFactory;
    
    protected $table = '2018';

    protected $timestamps = false;

    protected $fillable = [
        'DATA_SOURCE', 'IncidentTypeName', 'IncidentCode', 'IncidentID',
        'patientid', 'transport', 'INCIDENT_DATE', 'RINGTIME', 'ANSWERTIME', 'DISPATCHINGTIME',
        'DISPATCHINGTIME_ANSWERTIME_SECOND', 'DISPATCHINGTIME_ANSWERTIME_MINUTE', 'ACCEPTREFUSETIME',
        'MOVEMENTTIME', 'MOVEMENTTIME_ACCEPTREFUSETIME_SECOND', 'ReachSiteTime', 'ReachSiteTime_ACCEPTREFUSETIME_SECOND',
        'ReachSiteTime_ACCEPTREFUSETIME_MINUTE',
        'ReachSiteTime_AnswerTime_MINUTE', 'CaseTreatmentTime', 'CaseTreatmentTime_ReachSiteTime_SECOND', 'CaseTreatmentTime_ReachSiteTime_MINUTE',
        'MoveFromSiteTime',
        'MoveFromSiteTime_CaseTreatmentTime_MINUTE', 'ReachHospital', 'ReachHospital_MoveFromSiteTime_MINUTE',
        'LeaveHospital', 'SourceName', 'IncidentPriorityName'
    ];
}
