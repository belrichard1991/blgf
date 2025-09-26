<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table      = 'employees';    // <-- make sure this matches your DB table name
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'last_name','first_name','ext','middle_name','municipality','province','region',
        'plantilla_position','salary_grade','designation','gender','age','birthdate',
        'civil_status','is_real_estate_appraiser','license_no','date_of_license_registration',
        'date_of_license_expiration','email','contact_no','retirement_year','ipcr_rating',
        'date_of_last_laoe_conducted','Photo'
    ];
    protected $useTimestamps = false;
}
