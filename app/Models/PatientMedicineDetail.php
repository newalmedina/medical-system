<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatientMedicineDetail extends Model
{
    use HasFactory;

    protected $table = "patient_medicine_details";

    public function getPrescripcionStringAttribute()
    {
        //subiendo cambiosdsadsa
        return  $this->medicine . ', '  . $this->dosis . ', ' . $this->frecuency . ', ' . $this->period;
    }
}
