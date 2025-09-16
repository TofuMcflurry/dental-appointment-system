<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Patient extends Authenticatable
{
    protected $table = 'patients';
    protected $primaryKey = 'patient_id';

    protected $fillable = [
        'user_id',
        'full_name',
        'birthdate',
        'gender',
        'contact_number',
        'email',
        'address',
        'treatment_plan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public $timestamps = true;
}
