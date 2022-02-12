<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settingemr extends Model
{

    protected $fillable = ['id','emr_visit_limit','emr_bps','emr_bpd','emr_temperature','emr_pulse','emr_bw','emr_height','emr_bmi1','emr_bmi2','emr_checkup_icd10','created_at','updated_at'];

}