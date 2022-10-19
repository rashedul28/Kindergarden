<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Auth\Registration;
use App\Models\Class_model;
use App\Models\Active_student;
use App\Models\Result;
use App\Models\Marksheet;




class Student extends Model
{
    use HasFactory;
    public $timestamps = false;
   
  
    public function reg()
    {
        return $this->belongsTo(Registration::class);
    }
    public function sClass()
    {
        return $this->belongsTo(Class_model::class,'class_model_id');
    }


}
